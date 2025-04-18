<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\tpelogController;
use App\Http\Controllers\personalisedtrainingplanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\StandardExercisesController;
use App\Models\Client;
use App\Models\TpeLog;
use App\Models\Appointment;
use App\Models\Employee;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\StravaController;



/* |-------------------------------------------------------------------------- 
   | Web Routes 
   |-------------------------------------------------------------------------- */

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/client/new/{userid}', 'App\Http\Controllers\clientController@new')->name('client.new');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');


    Route::get('/employee/new/{userid}', [EmployeeController::class, 'new'])
    ->name('employee.new');

    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    // Logout Route
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // Clients About Page
    Route::get('/clients/about', function () {
        return view('clients.about');
    })->name('clients.about');

    // CRUD Routes for Employees, Clients, and Practices
    Route::resource('employees', EmployeeController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('practices', PracticeController::class);

    // FullCalendar Appointment Routes
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{id}/pay', [AppointmentController::class, 'payAppointment'])->name('appointments.pay');
    Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.available-slots');

    // Diary Entry Routes
    Route::resource('diary-entries', DiaryEntryController::class);
    Route::get('clients/{client_id}/diary-entries', [DiaryEntryController::class, 'index'])->name('diary-entries.client');
    Route::get('clients/{client_id}/diary-entries/create', [DiaryEntryController::class, 'create'])->name('diary-entries-create');

    // Notifications
    Route::resource('notifications', NotificationController::class);
    Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('notifications/create-test', [NotificationController::class, 'createTestNotification'])->name('notifications.test');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    Route::get('/profile/personal-details', [ProfileController::class, 'personalDetails'])->name('profile.personal-details');
    Route::get('/profile/about', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/profile/help', [ProfileController::class, 'help'])->name('profile.help');
    Route::post('/profile/personal-details', [ProfileController::class, 'updatePersonalDetails'])->name('profile.update-details');
// pp routes
    Route::post('/profile/upload-picture', [ProfileController::class, 'uploadProfilePicture'])
    ->name('profile.upload-picture');

    // Search Routes
    Route::get('/search-clients', [ClientController::class, 'searchClients'])->name('search.clients');
    Route::get('/search-employees', [EmployeeController::class, 'searchEmployees'])->name('search.employees');

    // Calendar Display Route
    Route::get('/calendar/display', [CalendarController::class, 'display'])->name('calendar.display');

    // Personalised Training Plans
    Route::resource('personalisedtrainingplans', personalisedtrainingplanController::class);
    Route::get('/personalised-training-plans/create', [personalisedtrainingplanController::class, 'create'])->name('personalisedTrainingPlans.create');
    Route::post('/personalised-training-plans/store', [personalisedtrainingplanController::class, 'store'])->name('personalisedTrainingPlans.store');

    // TPE Logs
    Route::resource('tpelogs', tpelogController::class);
    Route::get('/tpelog/create/{plan_id}', [tpelogController::class, 'create'])->name('tpelog.create');
    Route::post('/tpelog/store', [tpelogController::class, 'store'])->name('tpelog.store');
    Route::post('/update-workout-log/{id}', [\App\Http\Controllers\tpelogController::class, 'updateCompletion']);



    // Standard Exercises
    Route::resource('standardexercises', StandardExercisesController::class);

    // Progress and Workout Logs
    Route::get('/progress', function () {
        return view('clients.progress');
    })->name('progress');


    Route::get('/workoutlogs', function () {
        $user = Auth::user();
        if (!$user) return redirect('/login');
        $client = Client::where('userid', $user->id)->first();
        if (!$client) return redirect('/clientdashboard')->with('error', 'Client not found.');
        $workoutLogs = TpeLog::whereHas('trainingPlan', function ($query) use ($client) {
            $query->where('client_id', $client->id);
        })->with('standardExercise')->get();
        return view('clients.workoutlogs', compact('workoutLogs'));
    })->name('workoutlogs');

    // Client Profile
    Route::get('/clientprofile', [ClientProfileController::class, 'index'])->name('clientprofile');

    // Appointment API
    Route::get('/api/appointments', [AppointmentController::class, 'index']);

    // Appointment Notifications
    Route::get('/test-appointment-notification', function () {
        $user = Auth::user();
        if (!$user) return 'Not logged in';
        try {
            $appointment = (object)[
                'id' => 123,
                'booking_date' => date('Y-m-d'),
                'status' => 'confirmed',
                'notes' => 'Test appointment from route',
                'doctor_name' => 'Dr. Smith'
            ];
            $user->notify(new \App\Notifications\SimpleAppointmentNotification($appointment));
            return 'Appointment notification sent! Go check your notifications page.';
        } catch (\Exception $e) {
            \Log::error('Error creating appointment notification: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    })->middleware('auth');

    // Simple Test Notification
    Route::get('/simple-test', function () {
        $user = Auth::user();
        if (!$user) return 'Not logged in';
        try {
            $user->notify(new \App\Notifications\SimpleTestNotification());
            return 'Test notification sent successfully! Go check your notifications page.';
        } catch (\Exception $e) {
            \Log::error('Error creating simple notification: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    });

    // Appointment JSON API
    Route::get('/appointment/json', [AppointmentController::class, 'getAppointments'])->name('appointment.json');
});

// Public Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

require __DIR__.'/auth.php';


Route::get('/client/clientdashboard', [App\Http\Controllers\ClientController::class, 'clientdashboard'])
    ->name('client.clientdashboard')
    ->middleware('auth');

Route::get('/alerts', function () {
    return view('clients.alerts');
})->name('alerts');


Route::get('/alerts', [AppointmentController::class, 'upcoming'])->name('alerts');

Route::get('/dashboard', function () {
    $userId = Auth::id();

    $employee = \App\Models\Employee::where('userid', $userId)->first();

    if (!$employee) {
        return redirect('/')->with('error', 'Employee record not found for this user.');
    }

    $appointments = \App\Models\Appointment::where('employee_id', $employee->id)
        ->whereDate('start_time', '>=', now())
        ->get();

    $activeClients = \App\Models\Client::where('practice_id', $employee->practice_id)
        ->where('account_status', 'Active')
        ->count();

    return view('dashboard', compact('appointments', 'activeClients'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/client/help', function () {
    return view('clients.clienthelp');
})->name('client.help');

Route::get('/client/profile/edit', [ClientController::class, 'editClientProfile'])->name('client.editprofile');

Route::patch('/appointments/{id}/cancel', [App\Http\Controllers\AppointmentController::class, 'cancel'])->name('appointments.cancel');

//strava routes

Route::get('/strava/connect', [StravaController::class, 'redirectToStrava'])->name('strava.connect');
Route::get('/strava/callback', [StravaController::class, 'handleCallback'])->name('strava.callback');
Route::get('/strava/authorize', [StravaController::class, 'redirectToStrava'])->name('strava.authorize');
Route::get('/strava/activities', [\App\Http\Controllers\StravaController::class, 'fetchActivities'])
    ->middleware('auth')
    ->name('strava.activities');
//Route::get('/progress', [\App\Http\Controllers\StravaController::class, 'showProgressPage'])->name('progress');
//Route::get('/progress', [\App\Http\Controllers\StravaController::class, 'fetchActivities'])->name('progress');
//Route::get('/progress', [StravaController::class, 'showProgressPage'])->name('progress');
Route::get('/progress', [StravaController::class, 'showProgressPage'])->middleware('auth')->name('progress');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'global'])->name('search.global');













