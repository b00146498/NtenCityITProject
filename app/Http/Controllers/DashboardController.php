<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ensure it's an employee
        if (!$user || !$user->hasRole('employee')) {
            return redirect()->route('login')->with('error', 'Unauthorized');
        }

        $appointments = Appointment::where('employee_id', $user->id)
            ->whereDate('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        $clients = Client::where('practice_id', $user->practice_id ?? null)->get();

        return view('dashboard', compact('appointments', 'clients'));
    }
}

