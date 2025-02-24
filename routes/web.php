<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DiaryEntryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\AppointmentController; // ✅ Keep everything the same

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

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

// ✅ CRUD Routes for Employees, Clients, and Practices (Unchanged)
Route::resource('employees', App\Http\Controllers\EmployeeController::class);
Route::resource('clients', App\Http\Controllers\ClientController::class);
Route::resource('practices', App\Http\Controllers\PracticeController::class);

// ✅ Calendar Display Route (Unchanged)
Route::get('/calendar/display', [CalendarController::class, 'display'])
    ->name('calendar.display')
    ->middleware('auth');

// ✅ Full Appointment Management (Unchanged)
Route::resource('appointments', AppointmentController::class);

// ✅ Diary Entry Routes (Unchanged)
Route::get('diary-entries/create', [DiaryEntryController::class, 'create'])->name('diary-entries.create');
Route::get('diary-entries', [DiaryEntryController::class, 'index'])->name('diary-entries.index');
Route::get('clients/{client_id}/diary-entries', [DiaryEntryController::class, 'index'])->name('diary-entries.client');
Route::get('clients/{client_id}/diary-entries/create', [DiaryEntryController::class, 'create'])->name('diary-entries-create');
Route::post('diary-entries', [DiaryEntryController::class, 'store'])->name('diary-entries.store');
Route::get('diary-entries/{id}', [DiaryEntryController::class, 'show'])->name('diary-entries.show');
Route::get('diary-entries/{id}/edit', [DiaryEntryController::class, 'edit'])->name('diary-entries.edit');
Route::put('diary-entries/{id}', [DiaryEntryController::class, 'update'])->name('diary-entries.update');
Route::delete('diary-entries/{id}', [DiaryEntryController::class, 'destroy'])->name('diary-entries.destroy');

// ✅ ADDED: Client's Appointment View (For Wireframe)
Route::get('/my-appointments', [AppointmentController::class, 'clientAppointments'])->name('appointments.client');
