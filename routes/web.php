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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\StravaController;
use App\Http\Controllers\SearchController;
use App\Models\Client;
use App\Models\TpeLog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Make available-slots public
Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableTimeSlots'])->name('appointments.available-slots');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Client Routes
    Route::get('/client/new/{userid}', [ClientController::class, 'new'])->name('client.new');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/client/clientdashboard', [ClientController::class, 'clientdashboard'])->name('client.clientdashboard');
    Route::get('/client/help', function () {
        return view('clients.clienthelp');
    })->name('client.help');
    Route::get('/client/profile/edit', [ClientController::class, 'editClientProfile'])->name('client.editprofile');

    // Employee Routes
    Route::get('/employee/new/{userid}', [EmployeeController::class, 'new'])->name('employee.new');
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    // Logout
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // About Pages
    Route::get('/clients/about', function () {
        return view('clients.about');
    })->name('clients.about');

    // CRUD Resources
    Route::resource('employees', EmployeeController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('practices', PracticeController::class);
    Route::resource('standardexercises', StandardExercisesController::class);

    // FullCalendar Appointment Routes
    Route::resource('appointments', AppointmentController::class);
    Route::post('/appointments/{id}/pay', [AppointmentController::class, 'processPayment'])->name('appointments.pay');

    // Diary Entry Routes
    Route::resource('diary-entries', DiaryEntryController::class);
    Route::get('clients/{client_id}/diary-entries', [DiaryEntryController::class, 'index'])->name('diary-entries.client');
    Route::get('clients/{client_id}/diary-entries/create', [DiaryEntryController::class, 'create'])->name('diary-entries-create');

    // Notifications
    Route::resource('notifications', NotificationController::class);
    Route::put('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::put('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAsReadAll');
    Route::get('notifications/create-test', [NotificationController::class, 'createTestNotification'])->name('notifications.test');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/history', [ProfileController::class, 'history'])->name('profile.history');
    Route::get('/profile/personal-details', [ProfileController::class, 'personalDetails'])->name('profile.personal-details');
    Route::get('/profile/about', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/profile/help', [ProfileController::class, 'help'])->name('profile.help');
    Route::post('/profile/personal-details', [ProfileController::class, 'updatePersonalDetails'])->name('profile.update-details');
    Route::post('/profile/upload-picture', [ProfileController::class, 'uploadProfilePicture'])->name('profile.upload-picture');

    // Client Profile
    Route::get('/clientprofile', [ClientProfileController::class, 'index'])->name('clientprofile');

    // Search Routes
    Route::get('/search-clients', [ClientController::class, 'searchClients'])->name('search.clients');
    Route::get('/search-employees', [EmployeeController::class, 'searchEmployees'])->name('search.employees');
    Route::get('/search', [SearchController::class, 'global'])->name('search.global');

    // Calendar Display
    Route::get('/calendar/display', [CalendarController::class, 'display'])->name('calendar.display');

    // Personalised Training Plans
    Route::resource('personalisedtrainingplans', personalisedtrainingplanController::class);
    Route::get('/personalised-training-plans/create', [personalisedtrainingplanController::class, 'create'])->name('personalisedTrainingPlans.create');
    Route::post('/personalised-training-plans/store', [personalisedtrainingplanController::class, 'store'])->name('personalisedTrainingPlans.store');

    // TPE Logs
    Route::resource('tpelogs', tpelogController::class);
    Route::get('/tpelog/create/{plan_id}', [tpelogController::class, 'create'])->name('tpelog.create');
    Route::post('/tpelog/store', [tpelogController::class, 'store'])->name('tpelog.store');
    Route::post('/update-workout-log/{id}', [tpelogController::class, 'updateCompletion']);

    // Progress and Workout Logs
    Route::get('/progress', [StravaController::class, 'showProgressPage'])->name('progress');
    Route::get('/workoutlogs', function () {
        $user = Auth::user();
        if (!$user) {
            return redirect('/login');
        }
        $client = Client::where('userid', $user->id)->first();
        if (!$client) {
            return redirect('/clientdashboard')->with('error', 'Client not found.');
        }
        $workoutLogs = TpeLog::whereHas('trainingPlan', fn($q) => $q->where('client_id', $client->id))
            ->with('standardExercise')
            ->get();
        return view('clients.workoutlogs', compact('workoutLogs'));
    })->name('workoutlogs');

    // Alerts
    Route::get('/alerts', [AppointmentController::class, 'upcoming'])->name('alerts');

    // Strava Routes
    Route::get('/strava/connect', [StravaController::class, 'redirectToStrava'])->name('strava.connect');
    Route::get('/strava/callback', [StravaController::class, 'handleCallback'])->name('strava.callback');
    Route::get('/strava/authorize', [StravaController::class, 'redirectToStrava'])->name('strava.authorize');
    Route::get('/strava/activities', [StravaController::class, 'fetchActivities'])->name('strava.activities');

    // Test Routes
    Route::get('/test-appointment-notification', function () {
        $user = Auth::user();
        if (!$user) return 'Not logged in';
        try {
            $appointment = (object)[
                'id'           => 123,
                'booking_date' => date('Y-m-d'),
                'status'       => 'confirmed',
                'notes'        => 'Test appointment from route',
                'doctor_name'  => 'Dr. Smith',
            ];
            $user->notify(new \App\Notifications\SimpleAppointmentNotification($appointment));
            return 'Appointment notification sent! Go check your notifications page.';
        } catch (\Exception $e) {
            \Log::error('Error creating appointment notification: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    });

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

    // API Routes
    Route::get('/api/appointments', [AppointmentController::class, 'index']);
});
