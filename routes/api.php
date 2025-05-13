<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ClientController,
    PracticeController,
    EmployeeController,
    AppointmentController,
    DiaryEntryController,
    StandardExercisesController,
    personalisedtrainingplanController,
    tpelogController,
    NotificationController,
    StravaController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // User Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Clients API
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientController::class, 'apiIndex']);
        Route::get('/{id}', [ClientController::class, 'apiShow']);
        Route::post('/', [ClientController::class, 'apiStore']);
        Route::put('/{id}', [ClientController::class, 'apiUpdate']);
        Route::delete('/{id}', [ClientController::class, 'apiDestroy']);
        Route::get('/search', [ClientController::class, 'apiSearch']);
    });

    // Practices API
    Route::prefix('practices')->group(function () {
        Route::get('/', [PracticeController::class, 'apiIndex']);
        Route::get('/{id}', [PracticeController::class, 'apiShow']);
        Route::post('/', [PracticeController::class, 'apiStore']);
        Route::put('/{id}', [PracticeController::class, 'apiUpdate']);
        Route::delete('/{id}', [PracticeController::class, 'apiDestroy']);
    });

    // Employees API
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'apiIndex']);
        Route::get('/{id}', [EmployeeController::class, 'apiShow']);
        Route::post('/', [EmployeeController::class, 'apiStore']);
        Route::put('/{id}', [EmployeeController::class, 'apiUpdate']);
        Route::delete('/{id}', [EmployeeController::class, 'apiDestroy']);
    });

    // Appointments API
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'apiIndex']);
        Route::get('/available-slots', [AppointmentController::class, 'getAvailableTimeSlots']);
        Route::get('/{id}', [AppointmentController::class, 'apiShow']);
        Route::post('/', [AppointmentController::class, 'apiStore']);
        Route::put('/{id}', [AppointmentController::class, 'apiUpdate']);
        Route::delete('/{id}', [AppointmentController::class, 'apiDestroy']);
        Route::post('/{id}/pay', [AppointmentController::class, 'apiProcessPayment']);
    });

    // Diary Entries API
    Route::prefix('diary-entries')->group(function () {
        Route::get('/', [DiaryEntryController::class, 'apiIndex']);
        Route::get('/client/{client_id}', [DiaryEntryController::class, 'apiClientEntries']);
        Route::get('/{id}', [DiaryEntryController::class, 'apiShow']);
        Route::post('/', [DiaryEntryController::class, 'apiStore']);
        Route::put('/{id}', [DiaryEntryController::class, 'apiUpdate']);
        Route::delete('/{id}', [DiaryEntryController::class, 'apiDestroy']);
    });

    // Standard Exercises API
    Route::prefix('exercises')->group(function () {
        Route::get('/', [StandardExercisesController::class, 'apiIndex']);
        Route::get('/{id}', [StandardExercisesController::class, 'apiShow']);
        Route::post('/', [StandardExercisesController::class, 'apiStore']);
        Route::put('/{id}', [StandardExercisesController::class, 'apiUpdate']);
        Route::delete('/{id}', [StandardExercisesController::class, 'apiDestroy']);
    });

    // Training Plans API
    Route::prefix('training-plans')->group(function () {
        Route::get('/', [personalisedtrainingplanController::class, 'apiIndex']);
        Route::get('/client/{client_id}', [personalisedtrainingplanController::class, 'apiClientPlans']);
        Route::get('/{id}', [personalisedtrainingplanController::class, 'apiShow']);
        Route::post('/', [personalisedtrainingplanController::class, 'apiStore']);
        Route::put('/{id}', [personalisedtrainingplanController::class, 'apiUpdate']);
        Route::delete('/{id}', [personalisedtrainingplanController::class, 'apiDestroy']);
    });

    // TPE Logs API
    Route::prefix('tpe-logs')->group(function () {
        Route::get('/', [tpelogController::class, 'apiIndex']);
        Route::get('/plan/{plan_id}', [tpelogController::class, 'apiPlanLogs']);
        Route::get('/{id}', [tpelogController::class, 'apiShow']);
        Route::post('/', [tpelogController::class, 'apiStore']);
        Route::put('/{id}', [tpelogController::class, 'apiUpdate']);
        Route::put('/{id}/completion', [tpelogController::class, 'apiUpdateCompletion']);
        Route::delete('/{id}', [tpelogController::class, 'apiDestroy']);
    });

    // Notifications API
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'apiIndex']);
        Route::put('/{id}/read', [NotificationController::class, 'apiMarkAsRead']);
        Route::put('/read-all', [NotificationController::class, 'apiMarkAllAsRead']);
    });

    // Strava Integration API
    Route::prefix('strava')->group(function () {
        Route::get('/connect', [StravaController::class, 'apiRedirect']);
        Route::get('/callback', [StravaController::class, 'apiCallback']);
        Route::get('/activities', [StravaController::class, 'apiActivities']);
    });
});

// Public API endpoints (no auth required)
Route::get('/public/exercises', [StandardExercisesController::class, 'apiPublicIndex']);
Route::get('/public/practices', [PracticeController::class, 'apiPublicIndex']);