<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::resource('employees', App\Http\Controllers\employeeController::class); 

Route::resource('clients', App\Http\Controllers\clientController::class); 
use App\Http\Controllers\ClientController;

Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');


Route::resource('practices', App\Http\Controllers\practiceController::class); 


use App\Http\Controllers\CalendarController;

Route::get('/calendar/display', [CalendarController::class, 'display'])->name('calendar.display');




