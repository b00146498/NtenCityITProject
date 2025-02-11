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

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate(); // Invalidate session
    $request->session()->regenerateToken(); // Prevent CSRF issues
    return redirect('/login'); // Redirect to login page
})->name('logout');

Route::get('/login', function () {
    return view('auth.login'); // Ensure this file exists: resources/views/auth/login.blade.php
})->name('login');



require __DIR__.'/auth.php';

Route::resource('employees', App\Http\Controllers\employeeController::class); 

Route::resource('clients', App\Http\Controllers\clientController::class); 

Route::resource('practices', App\Http\Controllers\practiceController::class); 



