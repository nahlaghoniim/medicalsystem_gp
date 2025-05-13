<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\Doctor\PrescriptionController;
use App\Http\Controllers\Api\Doctor\AppointmentController;
use App\Http\Controllers\Api\Doctor\PatientNoteController;
use App\Http\Controllers\Api\Doctor\PaymentController;
use App\Http\Controllers\Api\Doctor\MedicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\Api\EmergencyAccessController;

Route::get('/emergency/{token}', [EmergencyAccessController::class, 'show']);

Route::get('/test', function (Request $request) {
    return response()->json([
        'message' => 'API is working',
        'status' => 200
    ]);
});

// Public (unauthenticated) routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected (authenticated) routes
Route::middleware('auth:sanctum')->group(function () {

    // Authenticated user profile
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });

    // Patient Routes
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::post('/', [PatientController::class, 'store']);
        Route::get('/', [PatientController::class, 'index']);
        Route::get('/{id}', [PatientController::class, 'show']);
        Route::put('/{id}', [PatientController::class, 'update']);
        Route::delete('/{id}', [PatientController::class, 'destroy']);
    });

    // Doctor's Prescription Routes
    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::post('/prescriptions/{patientId}', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::get('/prescriptions/{id}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
        Route::delete('/prescription-items/{id}', [PrescriptionController::class, 'destroyItem'])->name('prescriptions.destroyItem');
    });

    // Appointment Routes
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
        Route::delete('/{appointment}', [AppointmentController::class, 'destroy'])->name('destroy');
    });

    // Future additions (e.g. medications, settings, reports) can go here
    Route::post('patients/{patientId}/notes', [PatientNoteController::class, 'store'])
     ->name('patients.notes.store');

     Route::apiResource('payments', PaymentController::class)
     ->only(['index','store','show']);

     Route::get('medications/search', [MedicationController::class, 'search'])
     ->name('medications.search');

});
