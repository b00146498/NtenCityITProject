<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Client;

class StravaController extends Controller
{
    /*public function redirectToStrava()
    {
        $clientId = config('services.strava.client_id');
        $redirectUri = config('services.strava.redirect');

        return redirect()->away("https://www.strava.com/oauth/authorize?client_id={$clientId}&response_type=code&redirect_uri={$redirectUri}&approval_prompt=auto&scope=read,activity:read");
    }*/

    public function redirectToStrava()
    {
        $clientId = config('services.strava.client_id');
        $redirectUri = config('services.strava.redirect');
        $scope = 'read,activity:read_all';

        return redirect()->away("https://www.strava.com/oauth/authorize?client_id={$clientId}&response_type=code&redirect_uri={$redirectUri}&approval_prompt=auto&scope={$scope}");
    }

    /*public function handleCallback(Request $request)
    {
        $code = $request->input('code');

        $response = Http::withOptions([
            'verify' => false, // ⚠️ Local dev only
        ])->post('https://www.strava.com/oauth/token', [
            'client_id' => config('services.strava.client_id'),
            'client_secret' => config('services.strava.client_secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        $data = $response->json();

        $client = Client::where('userid', Auth::id())->first();

        if ($client && isset($data['access_token'])) {
            $client->update([
                'strava_access_token' => $data['access_token'],
                'strava_refresh_token' => $data['refresh_token'],
                'strava_token_expires_at' => Carbon::createFromTimestamp($data['expires_at']),
            ]);

            return redirect()->route('strava.activities')->with('success', 'Strava connected!');
        }

        return redirect()->route('workoutlogs')->with('error', 'Strava connection failed.');
    }*/

    public function handleCallback(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return redirect()->route('workoutlogs')->with('error', 'Missing authorization code.');
        }

        $response = Http::withOptions([
            'verify' => false, // ⚠️ DEV ONLY - disables SSL check locally
        ])->post('https://www.strava.com/oauth/token', [
            'client_id' => config('services.strava.client_id'),
            'client_secret' => config('services.strava.client_secret'),
            'code' => $code,
            'grant_type' => 'authorization_code',
        ]);

        $data = $response->json();

        if (!isset($data['access_token'])) {
            return redirect()->route('workoutlogs')->with('error', 'Failed to retrieve access token from Strava.');
        }

        $client = \App\Models\Client::where('userid', Auth::id())->first();

        if (!$client) {
            return redirect()->route('workoutlogs')->with('error', 'Client not found.');
        }

        // ✅ Save tokens to DB
        $client->update([
            'strava_access_token' => $data['access_token'],
            'strava_refresh_token' => $data['refresh_token'],
            'strava_token_expires_at' => Carbon::createFromTimestamp($data['expires_at']),
        ]);

        return redirect()->route('strava.activities')->with('success', 'Strava connected successfully!');
    }


    public function fetchActivities()
    {
        $client = \App\Models\Client::where('userid', Auth::id())->first();

        if (!$client || !$client->strava_access_token) {
            return redirect()->route('workoutlogs')->with('error', 'Strava not connected.');
        }

        $response = \Http::withOptions([
            'verify' => false, // ⚠️ Local dev only
        ])->withToken($client->strava_access_token)
        ->get('https://www.strava.com/api/v3/athlete/activities', [
            'per_page' => 5,
            'page' => 1,
        ]);

        $activities = $response->successful() ? $response->json() : [];

        // Build chart data
        $distances = [];
        $dates = [];

        foreach ($activities as $activity) {
            $distances[] = round($activity['distance'] / 1000, 2); // in km
            $dates[] = \Carbon\Carbon::parse($activity['start_date'])->format('d M');
        }

        return view('clients.progress', compact('activities', 'distances', 'dates'));
    }


    public function showActivities()
    {
        $client = Client::where('userid', Auth::id())->first();

        if (!$client || !$client->strava_access_token) {
            return redirect()->route('workoutlogs')->with('error', 'Strava account not connected.');
        }

        $accessToken = $client->strava_access_token;

        $response = Http::withOptions([
            'verify' => false, // ⚠️ Local dev only
        ])->withToken($accessToken)->get('https://www.strava.com/api/v3/athlete/activities', [
            'per_page' => 5,
            'page' => 1,
        ]);

        if ($response->failed()) {
            return redirect()->route('workoutlogs')->with('error', 'Failed to fetch Strava data.');
        }

        $activities = $response->json();

        return redirect()->route('progress')->with('success', 'Strava connected!');
    }
    public function showProgressPage()
    {
        $client = \App\Models\Client::where('userid', Auth::id())->first();
        $activities = [];
        $distances = [];
        $dates = [];
        $speeds = [];
        $activityTypes = [];

        if ($client && $client->strava_access_token) {
            $response = \Http::withOptions([
                'verify' => false, // ⚠️ DEV only
            ])->withToken($client->strava_access_token)
            ->get('https://www.strava.com/api/v3/athlete/activities', [
                'per_page' => 10,
                'page' => 1,
            ]);

            if ($response->successful()) {
                $activities = $response->json();

                foreach ($activities as $activity) {
                    $distances[] = round($activity['distance'] / 1000, 2);
                    $dates[] = Carbon::parse($activity['start_date'])->format('d M');
                    
                    // Speed in km/h
                    $speed = $activity['distance'] / $activity['elapsed_time'];
                    $speeds[] = round($speed * 3.6, 2);
                
                    // Count activity type
                    $type = $activity['type'] ?? 'Other';
                    $activityTypes[$type] = ($activityTypes[$type] ?? 0) + 1;
                }
            }
        }

        return view('clients.progress', compact(
            'activities',
            'distances',
            'dates',
            'speeds',
            'activityTypes'
        ));
    }

}
