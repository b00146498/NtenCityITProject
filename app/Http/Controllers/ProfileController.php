<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Practice;

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
    
    public function uploadProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'errors' => $validator->errors()->first('profile_picture')
            ], 400);
        }

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            try {
                // Determine if it's an employee or client
                if ($user->role === 'employee') {
                    $employee = Employee::where('userid', $user->id)->first();
                    
                    // Delete old picture if it exists
                    $this->deleteOldProfilePicture($employee->profile_picture);
                    
                    $image = $request->file('profile_picture');
                    $imageName = 'employee_' . $employee->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                    
                    // Create directory if it doesn't exist
                    $this->ensureProfilePictureDirectory();
                    
                    // Store image in the public/profile_pictures directory
                    $image->move(public_path('profile_pictures'), $imageName);
                    
                    // Update profile picture path in the database
                    $employee->profile_picture = 'profile_pictures/' . $imageName;
                    $employee->save();

                } elseif ($user->role === 'client') {
                    $client = Client::where('userid', $user->id)->first();
                    
                    // Delete old picture if it exists
                    $this->deleteOldProfilePicture($client->profile_picture);
                    
                    $image = $request->file('profile_picture');
                    $imageName = 'client_' . $client->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                    
                    // Create directory if it doesn't exist
                    $this->ensureProfilePictureDirectory();
                    
                    // Store image in the public/profile_pictures directory
                    $image->move(public_path('profile_pictures'), $imageName);
                    
                    // Update profile picture path in the database
                    $client->profile_picture = 'profile_pictures/' . $imageName;
                    $client->save();
                }

                return response()->json([
                    'success' => true, 
                    'path' => 'profile_pictures/' . $imageName
                ]);

            } catch (\Exception $e) {
                \Log::error('Profile Picture Upload Error: ' . $e->getMessage());
                return response()->json([
                    'success' => false, 
                    'message' => 'An error occurred while uploading the profile picture.'
                ], 500);
            }
        }

        return response()->json(['success' => false], 400);
    }
    
    public function personalDetails()
    {
        $user = Auth::user();
        $employee = null;
        $client = null;
        $practices = Practice::all(); // Load all practices for potential use
        
        if ($user->role === 'employee') {
            $employee = Employee::where('userid', $user->id)->first();
        } else if ($user->role === 'client') {
            $client = Client::where('userid', $user->id)->first();
        }
        
        return view('profile.personal-details', compact('user', 'employee', 'client', 'practices'));
    }
    
    public function updatePersonalDetails(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'employee') {
            $employee = Employee::where('userid', $user->id)->first();
            
            if (!$employee) {
                return redirect()->route('profile')->with('error', 'Employee profile not found.');
            }
            
            $validationRules = [
                'emp_first_name' => 'required|string|max:50',
                'emp_surname' => 'required|string|max:50',
                'contact_number' => 'required|string|max:15',
                'emergency_contact' => 'required|string|max:50',
                'email' => 'required|email|max:255|unique:employee,email,' . $employee->id,
                'street' => 'required|string|max:255',
                'city' => 'required|string|max:50',
                'county' => 'required|string|max:50',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];

            // Validate the request
            $validatedData = $request->validate($validationRules);
            
            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $this->handleProfilePictureUpload($employee, $request->file('profile_picture'));
            }
            
            // Update the employee record with form data
            $employee->fill($validatedData);
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

    // Helper methods
    private function deleteOldProfilePicture($path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }

    private function ensureProfilePictureDirectory()
    {
        if (!File::exists(public_path('profile_pictures'))) {
            File::makeDirectory(public_path('profile_pictures'), 0755, true);
        }
    }

    private function handleProfilePictureUpload($model, $image)
    {
        // Delete old picture if it exists
        $this->deleteOldProfilePicture($model->profile_picture);
        
        $imageName = $model->getTable() . '_' . $model->id . '_' . time() . '.' . $image->getClientOriginalExtension();
        
        // Create directory if it doesn't exist
        $this->ensureProfilePictureDirectory();
        
        // Store image in the public/profile_pictures directory
        $image->move(public_path('profile_pictures'), $imageName);
        
        // Update profile picture path in the database
        $model->profile_picture = 'profile_pictures/' . $imageName;
    }
}