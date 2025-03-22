<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                // Delete old picture if it exists
                if ($employee->profile_picture && File::exists(public_path($employee->profile_picture))) {
                    File::delete(public_path($employee->profile_picture));
                }
                
                $image = $request->file('profile_picture');
                $imageName = 'employee_' . $employee->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                if (!File::exists(public_path('profile_pictures'))) {
                    File::makeDirectory(public_path('profile_pictures'), 0755, true);
                }
                
                // Store image in the public/profile_pictures directory
                $image->move(public_path('profile_pictures'), $imageName);
                
                // Update profile picture path in the database
                $employee->profile_picture = 'profile_pictures/' . $imageName;
            }
            
            // Update the employee record with form data
            $employee->emp_first_name = $request->emp_first_name;
            $employee->emp_surname = $request->emp_surname;
            $employee->contact_number = $request->contact_number;
            $employee->emergency_contact = $request->emergency_contact;
            $employee->email = $request->email;
            $employee->street = $request->street;
            $employee->city = $request->city;
            $employee->county = $request->county;
            $employee->save();
            
            // Also update the user record email if needed
            if ($user->email != $request->email) {
                $user->email = $request->email;
                $user->save();
            }
        } else if ($user->role === 'client') {
            // Handle client update logic here
            $client = Client::where('userid', $user->id)->first();
            
            if (!$client) {
                return redirect()->route('profile')->with('error', 'Client profile not found.');
            }
            
            // Add client-specific validation and update logic here
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