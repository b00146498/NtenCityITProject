<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Practice;
use App\Models\User;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employee = null;
        $client = null;
        
        if ($user->role === 'employee') {
            $employee = Employee::where('userid', $user->id)->first();
            
            // Debug: Check if employee has a profile picture
            \Log::info('Employee profile accessed', [
                'employee_id' => $employee ? $employee->id : 'null',
                'profile_picture' => $employee ? $employee->profile_picture : 'null'
            ]);
            
            // Ensure full path is used for profile picture
            if ($employee && $employee->profile_picture) {
                if (!str_starts_with($employee->profile_picture, 'profile_pictures/')) {
                    $employee->profile_picture = 'profile_pictures/' . $employee->profile_picture;
                    $employee->save();
                    \Log::info('Updated employee profile picture path', [
                        'new_path' => $employee->profile_picture
                    ]);
                }
            }
        } else if ($user->role === 'client') {
            $client = Client::where('userid', $user->id)->first();
            
            // Debug: Check if client has a profile picture
            \Log::info('Client profile accessed', [
                'client_id' => $client ? $client->id : 'null',
                'profile_picture' => $client ? $client->profile_picture : 'null'
            ]);
            
            // Similar logic for client
            if ($client && $client->profile_picture) {
                if (!str_starts_with($client->profile_picture, 'profile_pictures/')) {
                    $client->profile_picture = 'profile_pictures/' . $client->profile_picture;
                    $client->save();
                    \Log::info('Updated client profile picture path', [
                        'new_path' => $client->profile_picture
                    ]);
                }
            }
        }
        
        return view('profile.index', compact('user', 'employee', 'client'));
    }
    
    public function uploadProfilePicture(Request $request)
    {
        \Log::info('Profile picture upload initiated', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role
        ]);
        
        $validator = Validator::make($request->all(), [
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            \Log::warning('Profile picture validation failed', [
                'errors' => $validator->errors()->first('profile_picture')
            ]);
            
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
                    
                    \Log::info('Employee profile picture upload', [
                        'employee_id' => $employee->id,
                        'old_picture' => $employee->profile_picture
                    ]);
                    
                    // Delete old picture if it exists
                    $this->deleteOldProfilePicture($employee->profile_picture);
                    
                    $image = $request->file('profile_picture');
                    $imageName = 'employee_' . $employee->id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    
                    \Log::info('Generated image name', [
                        'image_name' => $imageName
                    ]);
                    
                    // Ensure the directory exists in storage
                    Storage::disk('public')->makeDirectory('profile_pictures', 0755, true);
                    
                    // Resize and optimize the image
                    $processedImage = Image::make($image)
                        ->fit(300, 300, function ($constraint) {
                            $constraint->upsize();
                        })
                        ->encode($image->getClientOriginalExtension(), 75);
                    
                    // Save the processed image to storage
                    $path = 'profile_pictures/' . $imageName;
                    Storage::disk('public')->put($path, $processedImage->__toString());
                    
                    \Log::info('Image saved to storage', [
                        'path' => $path,
                        'full_url' => Storage::url($path),
                        'exists' => Storage::disk('public')->exists($path)
                    ]);
                    
                    // Update profile picture path in the database
                    $employee->profile_picture = $path;
                    $employee->save();
                    
                    \Log::info('Employee profile updated', [
                        'profile_picture' => $employee->profile_picture
                    ]);

                    return response()->json([
                        'success' => true, 
                        'path' => Storage::url($path),
                        'debug_info' => [
                            'stored_path' => $path,
                            'full_url' => Storage::url($path),
                            'file_exists' => Storage::disk('public')->exists($path)
                        ]
                    ]);

                } elseif ($user->role === 'client') {
                    $client = Client::where('userid', $user->id)->first();
                    
                    \Log::info('Client profile picture upload', [
                        'client_id' => $client->id,
                        'old_picture' => $client->profile_picture
                    ]);
                    
                    // Delete old picture if it exists
                    $this->deleteOldProfilePicture($client->profile_picture);
                    
                    $image = $request->file('profile_picture');
                    $imageName = 'client_' . $client->id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                    
                    \Log::info('Generated image name', [
                        'image_name' => $imageName
                    ]);
                    
                    // Ensure the directory exists in storage
                    Storage::disk('public')->makeDirectory('profile_pictures', 0755, true);
                    
                    // Resize and optimize the image
                    $processedImage = Image::make($image)
                        ->fit(300, 300, function ($constraint) {
                            $constraint->upsize();
                        })
                        ->encode($image->getClientOriginalExtension(), 75);
                    
                    // Save the processed image to storage
                    $path = 'profile_pictures/' . $imageName;
                    Storage::disk('public')->put($path, $processedImage->__toString());
                    
                    \Log::info('Image saved to storage', [
                        'path' => $path,
                        'full_url' => Storage::url($path),
                        'exists' => Storage::disk('public')->exists($path)
                    ]);
                    
                    // Update profile picture path in the database
                    $client->profile_picture = $path;
                    $client->save();
                    
                    \Log::info('Client profile updated', [
                        'profile_picture' => $client->profile_picture
                    ]);

                    return response()->json([
                        'success' => true, 
                        'path' => Storage::url($path),
                        'debug_info' => [
                            'stored_path' => $path,
                            'full_url' => Storage::url($path),
                            'file_exists' => Storage::disk('public')->exists($path)
                        ]
                    ]);
                }

            } catch (\Exception $e) {
                \Log::error('Profile Picture Upload Error: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                return response()->json([
                    'success' => false, 
                    'message' => 'An error occurred while uploading the profile picture: ' . $e->getMessage()
                ], 500);
            }
        }

        \Log::warning('Profile picture upload failed - no file provided');
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
        
        try {
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

                // Validate the request with custom error messages
                $validatedData = $request->validate($validationRules, [
                    'emp_first_name.required' => 'First name is required.',
                    'emp_surname.required' => 'Surname is required.',
                    'contact_number.required' => 'Contact number is required.',
                    'emergency_contact.required' => 'Emergency contact is required.',
                    'email.required' => 'Email is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'street.required' => 'Street address is required.',
                    'city.required' => 'City is required.',
                    'county.required' => 'County is required.',
                ]);
                
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

                return redirect()->route('profile.personal-details')
                                 ->with('success', 'Personal details updated successfully.');
            } 
        } catch (\Exception $e) {
            // Log the full error for debugging
            \Log::error('Profile Update Error: ' . $e->getMessage());
            
            // Return with a generic error message
            return redirect()->back()
                             ->with('error', 'An error occurred while updating your profile. ' . $e->getMessage())
                             ->withInput();
        }

        // If not an employee, return with an error
        return redirect()->route('profile')->with('error', 'Invalid user role.');
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
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            \Log::info('Deleted old profile picture', ['path' => $path]);
        } else if ($path) {
            \Log::warning('Could not delete old profile picture - file does not exist', ['path' => $path]);
        }
    }

    private function ensureProfilePictureDirectory()
    {
        Storage::disk('public')->makeDirectory('profile_pictures', 0755, true);
        \Log::info('Ensured profile pictures directory exists');
    }

    private function handleProfilePictureUpload($model, $image)
    {
        // Delete old picture if it exists
        $this->deleteOldProfilePicture($model->profile_picture);
        
        $imageName = $model->getTable() . '_' . $model->id . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        
        // Ensure the directory exists
        $this->ensureProfilePictureDirectory();
        
        // Resize and optimize the image
        $processedImage = Image::make($image)
            ->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            })
            ->encode($image->getClientOriginalExtension(), 75);
        
        // Save the processed image to storage
        $path = 'profile_pictures/' . $imageName;
        Storage::disk('public')->put($path, $processedImage->__toString());
        
        \Log::info('Profile picture uploaded via form handler', [
            'path' => $path,
            'exists' => Storage::disk('public')->exists($path)
        ]);
        
        // Update profile picture path in the database
        $model->profile_picture = $path;
    }
}