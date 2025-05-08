<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Practice;
use App\Models\User;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

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
                if (!str_starts_with($employee->profile_picture, 'profile_pictures/') && 
                    !str_starts_with($employee->profile_picture, 'uploads/')) {
                    $employee->profile_picture = 'uploads/' . $employee->profile_picture;
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
                if (!str_starts_with($client->profile_picture, 'profile_pictures/') && 
                    !str_starts_with($client->profile_picture, 'uploads/')) {
                    $client->profile_picture = 'uploads/' . $client->profile_picture;
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
        try {
            \Log::info('Starting profile picture upload');
            
            if (!$request->hasFile('profile_picture')) {
                \Log::error('No file found in request');
                return response()->json(['success' => false, 'message' => 'No file provided'], 400);
            }
            
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            
            // Move file to uploads folder
            $file->move(public_path('uploads'), $filename);
            $path = 'uploads/' . $filename;
            
            \Log::info('File uploaded to disk successfully', ['path' => $path]);
            
            // Get user and explicitly update database
            $user = Auth::user();
            \Log::info('Current user', ['id' => $user->id, 'role' => $user->role]);
            
            if ($user->role === 'employee') {
                $employee = Employee::where('userid', $user->id)->first();
                
                if (!$employee) {
                    \Log::error('Employee not found for user', ['user_id' => $user->id]);
                    return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
                }
                
                \Log::info('Found employee', ['id' => $employee->id]);
                
                // Direct database update for testing
                DB::table('employee')
                    ->where('id', $employee->id)
                    ->update(['profile_picture' => $path]);
                
                // Double-check the update worked
                $updated = Employee::find($employee->id);
                \Log::info('After update check', ['profile_picture' => $updated->profile_picture]);
                
            } elseif ($user->role === 'client') {
                // Similar code for clients
                $client = Client::where('userid', $user->id)->first();
                
                if (!$client) {
                    \Log::error('Client not found for user', ['user_id' => $user->id]);
                    return response()->json(['success' => false, 'message' => 'Client not found'], 404);
                }
                
                DB::table('client')
                    ->where('id', $client->id)
                    ->update(['profile_picture' => $path]);
            }
            
            \Log::info('Database update completed');
            return response()->json([
                'success' => true, 
                'path' => asset($path),
                'debug' => [
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'saved_path' => $path
                ]
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Exception in uploadProfilePicture: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Error uploading profile picture: ' . $e->getMessage()
            ], 500);
        }
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
                    'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
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
    private function handleProfilePictureUpload($model, $image)
    {
        // Make sure model is not null
        if (!$model) {
            \Log::error('Cannot upload profile picture - model is null');
            return;
        }
        
        // Create directory if it doesn't exist - use uploads directory for consistency
        if (!File::exists(public_path('uploads'))) {
            File::makeDirectory(public_path('uploads'), 0755, true);
        }
        
        // Delete old picture if it exists
        if ($model->profile_picture && File::exists(public_path($model->profile_picture))) {
            File::delete(public_path($model->profile_picture));
            \Log::info('Deleted old profile picture', ['path' => $model->profile_picture]);
        }
        
        // Generate a simple filename
        $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        
        // Move the file directly to uploads directory
        $image->move(public_path('uploads'), $imageName);
        $path = 'uploads/' . $imageName;
        
        \Log::info('Profile picture uploaded via form handler', [
            'path' => $path
        ]);
        
        // Update profile picture path in the database using direct query
        $tableName = $model->getTable();
        DB::table($tableName)
            ->where('id', $model->id)
            ->update(['profile_picture' => $path]);
            
        // Update the model instance as well
        $model->profile_picture = $path;
    }
    public function store(Request $request, ImageManager $imageManager)
    {
        $image = $imageManager->read($request->file('photo')->getPathname());

        $resized = $image->scale(width: 300, height: 300);

        $resized->toPng()->save(storage_path('app/public/image.png'));
    }
}