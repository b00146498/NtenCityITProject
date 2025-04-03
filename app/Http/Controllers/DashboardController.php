<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\Employee;
use App\Services\WeatherService;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /*public function index()
    {
        $user = auth()->user();

        $employee = \App\Models\Employee::where('userid', $user->id)->first();

        if (!$employee) {
            return redirect()->route('login')->with('error', 'Employee not found.');
        }

        $appointments = \App\Models\Appointment::where('employee_id', $employee->id)
            ->whereDate('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        $clients = \App\Models\Client::where('practice_id', $employee->practice_id)->get();

        $activeClients = $clients->where('account_status', 'Active')->count(); // ✅ Filter active ones

        $company_name = optional($employee->practice)->company_name ?? 'Unknown Practice';

        return view('dashboard', compact(
            'appointments',
            'clients',
            'employee',
            'company_name',
            'activeClients' // ✅ pass to view
        ));
    }*/

    public function index(WeatherService $weatherService)
    {
        $user = auth()->user();

        $employee = \App\Models\Employee::where('userid', $user->id)->first();

        if (!$employee) {
            return redirect()->route('login')->with('error', 'Employee not found.');
        }

        $appointments = \App\Models\Appointment::where('employee_id', $employee->id)
            ->whereDate('start_time', '>=', now())
            ->orderBy('start_time', 'asc')
            ->take(5)
            ->get();

        $clients = \App\Models\Client::where('practice_id', $employee->practice_id)->get();
        $activeClients = $clients->where('account_status', 'Active')->count();

        $activeClients = $clients->where('account_status', 'Active')->count();

        $company_name = optional($employee->practice)->company_name ?? 'Unknown Practice';

        // Get weather data
        $weather = $weatherService->getWeather('Dublin'); // Or use another city

        return view('dashboard', compact(
            'appointments',
            'clients',
            'employee',
            'company_name',
            'activeClients',
            'weather' 
        ));
    }


    


  
}

