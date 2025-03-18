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
use App\Models\Client;
use App\Models\PersonalisedTrainingPlan;
use App\Models\TpeLog;
use App\Models\StandardExercises;

/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- */

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');



Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    
    $request->session()->regenerateToken();
    
    return redirect()->route('login');
})->name('logout');

require __DIR__.'/auth.php';

// CRUD Routes for Employees, Clients, and Practices
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('clients', App\Http\Controllers\ClientController::class);
Route::resource('practices', App\Http\Controllers\PracticeController::class);

// Restrict Calendar & Appointments Access to Authenticated Users
Route::middleware(['auth'])->group(function () {
    
    // FullCalendar Appointment Routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::post('/appointments/{id}/pay', [AppointmentController::class, 'payAppointment'])->name('appointments.pay');
    // NEW ROUTE: Get available time slots
    Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.available-slots');
    
    // Diary Entry Routes (Restricted to Authenticated Users)
    Route::get('diary-entries/create', [DiaryEntryController::class, 'create'])->name('diary-entries.create');
    Route::get('diary-entries', [DiaryEntryController::class, 'index'])->name('diary-entries.index');
    Route::get('clients/{client_id}/diary-entries', [DiaryEntryController::class, 'index'])->name('diary-entries.client');
    Route::get('clients/{client_id}/diary-entries/create', [DiaryEntryController::class, 'create'])->name('diary-entries-create');
    Route::post('diary-entries', [DiaryEntryController::class, 'store'])->name('diary-entries.store');
    Route::get('diary-entries/{id}', [DiaryEntryController::class, 'show'])->name('diary-entries.show');
    Route::get('diary-entries/{id}/edit', [DiaryEntryController::class, 'edit'])->name('diary-entries.edit');
    Route::put('diary-entries/{id}', [DiaryEntryController::class, 'update'])->name('diary-entries.update');
    Route::delete('diary-entries/{id}', [DiaryEntryController::class, 'destroy'])->name('diary-entries.destroy');
    Route::get('/search-clients', [App\Http\Controllers\ClientController::class, 'searchClients']);
    
    // Notification Routes
    Route::resource('notifications', App\Http\Controllers\NotificationController::class);
    Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
Route::get('/simple-test', function() {
    $user = Auth::user();
    
    if (!$user) {
        return 'Not logged in';
    }
    
    try {
        $user->notify(new \App\Notifications\SimpleTestNotification());
        return 'Test notification sent successfully! Go check your notifications page.';
    } catch (\Exception $e) {
        \Log::error('Error creating simple notification: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();
    }
})->middleware('auth');
Route::get('/test-appointment-notification', function() {
    $user = Auth::user();
    
    if (!$user) {
        return 'Not logged in';
    }
    
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
Route::get('/search-clients', [App\Http\Controllers\ClientController::class, 'searchClients']);
Route::get('/search-clients', [PersonalisedTrainingPlanController::class, 'searchClients'])->name('search.clients');

Route::get('/search-employees', [App\Http\Controllers\EmployeeController::class, 'searchEmployees'])->name('search.employees');

// Calendar Display Route (Using CalendarController)
Route::get('/calendar/display', [CalendarController::class, 'display'])
    ->name('calendar.display')
    ->middleware('auth');

// ✅ Use AppointmentController for Full CRUD (Ensure it's included)
Route::resource('appointments', AppointmentController::class);

Route::get('/loggedInClient','App\Http\Controllers\clientController@getLoggedInClientDetails');

Route::get('/client/clientdashboard', [App\Http\Controllers\ClientController::class, 'clientdashboard'])->name('client.clientdashboard');

Route::get('/client/new/{userid}', 'App\Http\Controllers\clientController@new')->name('client.new');
Route::get('/employee/new/{userid}', 'App\Http\Controllers\employeeController@new')->name('employee.new');
Route::resource('customers', App\Http\Controllers\customerController::class);

Route::get('/employee/new/{userid}', [App\Http\Controllers\EmployeeController::class, 'new'])->name('employee.new');

// Web Routes in Laravel
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index')->middleware('auth');
Route::get('/appointments/calendar', [CalendarController::class, 'display'])->name('calendar.display')->middleware('auth');
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create')->middleware('auth');
Route::get('/api/appointments', [AppointmentController::class, 'index']);
Route::get('notifications/create-test', [App\Http\Controllers\NotificationController::class, 'createTestNotification'])
    ->name('notifications.test')->middleware('auth');

Route::resource('standardexercises', App\Http\Controllers\standardexercisesController::class);


Route::resource('tpelogs', App\Http\Controllers\tpelogController::class);


Route::resource('personalisedtrainingplans', App\Http\Controllers\personalisedtrainingplanController::class);

Route::get('/personalised-training-plans/create', [PersonalisedTrainingPlanController::class, 'create'])->name('personalisedTrainingPlans.create');
Route::post('/personalised-training-plans/store', [PersonalisedTrainingPlanController::class, 'store'])->name('personalisedTrainingPlans.store');

Route::get('/tpelog/create/{plan_id}', [tpelogController::class, 'create'])->name('tpelog.create');
Route::post('/tpelog/store', [tpelogController::class, 'store'])->name('tpelog.store');

Route::get('/calendar/display', [AppointmentController::class, 'display'])->name('calendar.display')->middleware('auth');
Route::get('/appointment/json', 'App\Http\Controllers\AppointmentController@getAppointments')->name('appointment.json')->middleware('auth');



Route::get('/progress', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect('/login');
    }

    // Find the client linked to the logged-in user
    $client = Client::where('userid', $user->id)->first();

    if (!$client) {
        return redirect('/clientdashboard')->with('error', 'Client not found.');
    }

    // Get the latest training plan for the client
    $trainingPlan = PersonalisedTrainingPlan::where('client_id', $client->id)->latest()->first();

    if (!$trainingPlan) {
        return view('clients.progress', ['exerciseVideo' => null]);
    }

    // Find the most recent exercise linked to the training plan
    $exercise = TpeLog::where('plan_id', $trainingPlan->id)
        ->join('standardexercises', 'tpelog.exercise_id', '=', 'standardexercises.id')
        ->select('standardexercises.exercise_video_link')
        ->latest('tpelog.created_at')
        ->first();

    return view('clients.progress', ['exerciseVideo' => $exercise ? $exercise->exercise_video_link : null]);
})->name('progress');

Route::get('/workoutlogs', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect('/login');
    }

    // Find the client linked to the logged-in user
    $client = Client::where('userid', $user->id)->first();

    if (!$client) {
        return redirect('/clientdashboard')->with('error', 'Client not found.');
    }

    // Get the workout logs (exercises) assigned to this client
    $workoutLogs = TpeLog::whereHas('trainingPlan', function ($query) use ($client) {
        $query->where('client_id', $client->id);
    })->with('standardExercise')->get();

    return view('clients.workoutlogs', compact('workoutLogs'));
})->name('workoutlogs');
