<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiaryEntry;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DiaryEntryController extends Controller
{
    /**
     * Display a listing of the diary entries for a client.
     */
    public function index(Request $request, $client_id = null)
    {
        if ($client_id) {
            // If client_id is provided, fetch that specific client's diary entries
            $client = Client::findOrFail($client_id);
            $query = $client->diaryEntries()->latest();
        } else {
            // If no client_id, fetch all diary entries
            $query = DiaryEntry::latest();
            $client = null; // No specific client selected
        }

        // Handle search filtering
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                ->orWhere('surname', 'like', "%$search%");
            });
        }

        $diaryEntries = $query->get();

        return view('diary_entries.index', compact('client', 'diaryEntries'));
    }

    /**
     * Show the form for creating a new diary entry.
     */
    public function create($client_id = null)
    {
        if ($client_id) {
            //  Fetch the specific client for a pre-selected form
            $client = Client::findOrFail($client_id);
            return view('diary_entries.create', compact('client'));
        } else {
            //  Fetch all clients for a dropdown selection
            $clients = Client::all();
            return view('diary_entries.create', compact('clients'));
        }
    }
    
    /**
     * Store a newly created diary entry in storage.
     */

    public function store(Request $request)
    {
        //echo Auth::id();
        $diaryEntry = DiaryEntry::create([
            'employee_id' => Auth::id(),
            'client_id' => $request->client_id,
            'entry_date' => now(),
            'content' => $request->content,
        ]);
        $diaryEntry->save();
        //Log::info('Diary Entry Created:', $diaryEntry->toArray());
     
        return redirect()->route('diary-entries.index')->with('success', 'Diary entry added.');
    }
     
    /**
     * Display the specified diary entry.
     */
    /*public function show($id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);
        $client = $diaryEntry->client; // Fetch client details

        return view('diary_entries.show', compact('diaryEntry', 'client'));
    }*/

    public function show($id)
    {
        $diaryEntry = DiaryEntry::with(['employee', 'client'])->findOrFail($id);
        $client = $diaryEntry->client;

        // Default empty data
        $activities = [];
        $distances = [];
        $dates = [];
        $speeds = [];
        $activityTypes = [];

        if ($client && $client->strava_access_token) {
            $response = Http::withOptions([
                'verify' => false, // Dev only
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

                    $speed = $activity['distance'] / $activity['elapsed_time'];
                    $speeds[] = round($speed * 3.6, 2);

                    $type = $activity['type'] ?? 'Other';
                    $activityTypes[$type] = ($activityTypes[$type] ?? 0) + 1;
                }
            }
        }

        return view('diary_entries.show', compact(
            'diaryEntry',
            'client',
            'activities',
            'distances',
            'dates',
            'speeds',
            'activityTypes'
        ));
    }

    /**
     * Show the form for editing a diary entry.
     */
    public function edit($id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);

        // Ensure only the assigned employee can edit
        if ((int) $diaryEntry->employee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('diary_entries.edit', compact('diaryEntry'));
    }

    /**
     * Update the specified diary entry in storage.
     */
    public function update(Request $request, $id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);

        // Ensure only the assigned employee can update
        if ((int) $diaryEntry->employee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $diaryEntry->update([
            'content' => $request->content,
        ]);

        return redirect()->route('diary-entries.index')->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified diary entry from storage.
     */
    public function destroy($id)
    {
        $diaryEntry = DiaryEntry::findOrFail($id);

        // Ensure only the assigned employee can delete
        if ((int) $diaryEntry->employee_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $diaryEntry->delete();
        return redirect()->back()->with('success', 'Diary entry deleted.');
    }
}