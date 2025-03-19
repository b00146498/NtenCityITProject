<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Client;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = null;
        $client = null;
        
        if ($user->role === 'employee') {
            $employee = Employee::where('userid', $user->id)->first();
        } else if ($user->role === 'client') {
            $client = Client::where('userid', $user->id)->first();
        }
        
        return view('profile.index', compact('user', 'employee', 'client'));
    }
    
    public function personalDetails()
    {
        $user = Auth::user();
        $employee = null;
        $client = null;
        
        if ($user->role === 'employee') {
            $employee = Employee::where('userid', $user->id)->first();
        } else if ($user->role === 'client') {
            $client = Client::where('userid', $user->id)->first();
        }
        
        return view('profile.personal-details', compact('user', 'employee', 'client'));
    }
    
    public function updatePersonalDetails(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'employee') {
            $employee = Employee::where('userid', $user->id)->first();
            
            if (!$employee) {
                return redirect()->route('profile')->with('error', 'Employee profile not found.');
            }
            
            $request->validate([
                'emp_first_name' => 'required|string|max:50',
                'emp_surname' => 'required|string|max:50',
                'contact_number' => 'required|string|max:15',
                'emergency_contact' => 'required|string|max:50',
                'email' => 'required|email|max:255|unique:employee,email,' . $employee->id,
                'street' => 'required|string|max:255',
                'city' => 'required|string|max:50',
                'county' => 'required|string|max:50',
            ]);
            
            // Update the employee record
            $employee->update($request->all());
            
            // Also update the user record email if needed
            if ($user->email != $request->email) {
                $user->email = $request->email;
                $user->save();
            }
        } else if ($user->role === 'client') {
            // Handle client update logic here
        }
        
        return redirect()->route('profile.personal-details')
                         ->with('success', 'Personal details updated successfully.');
    }
    
    public function about()
    {
        return view('profile.about');
    }
    
    public function help()
    {
        return view('profile.help');
    }
}