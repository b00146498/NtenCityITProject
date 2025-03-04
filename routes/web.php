<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AppointmentController;

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
});
Route::get('/search-clients', [App\Http\Controllers\ClientController::class, 'searchClients']);

// Calendar Display Route (Using CalendarController)
Route::get('/calendar/display', [CalendarController::class, 'display'])
    ->name('calendar.display')
    ->middleware('auth');

// ✅ Use AppointmentController for Full CRUD (Ensure it's included)
Route::resource('appointments', AppointmentController::class);

Route::get('/loggedInClient','App\Http\Controllers\clientController@getLoggedInClientDetails');

Route::get('/client/new/{userid}', 'App\Http\Controllers\clientController@new')->name('client.new');
Route::get('/employee/new/{userid}', 'App\Http\Controllers\employeeController@new')->name('employee.new');
Route::resource('customers', App\Http\Controllers\customerController::class);


// Web Routes in Laravel
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index')->middleware('auth');
Route::get('/appointments/calendar', [CalendarController::class, 'display'])->name('calendar.display')->middleware('auth');
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create')->middleware('auth');
