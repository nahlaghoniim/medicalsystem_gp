<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Doctor\DashboardController;
use App\Http\Controllers\Doctor\PrescriptionController;
use App\Http\Controllers\Doctor\PrescriptionItemController;
use App\Http\Controllers\Doctor\PatientController;
use App\Http\Controllers\Doctor\AppointmentController;
use App\Http\Controllers\Doctor\PatientNoteController;
use App\Http\Controllers\Doctor\PaymentController;
use App\Http\Controllers\Doctor\MedicationController;
use App\Http\Controllers\Doctor\SettingController;
use App\Http\Controllers\Pharmacist\DashboardController as PharmacistDashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Social Login
Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Doctor Dashboard Routes
Route::middleware(['auth', 'verified', 'doctor'])->prefix('doctor/dashboard')->name('dashboard.doctor.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Patients
    Route::prefix('patients')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('patients.index');
        Route::get('/create', [PatientController::class, 'create'])->name('patients.create');
        Route::post('/', [PatientController::class, 'store'])->name('patients.store');
        Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
        Route::put('/{patient}', [PatientController::class, 'update'])->name('patients.update');
        Route::get('/{patient}', [PatientController::class, 'show'])->name('patients.show');
        Route::post('/{patient}/notes', [PatientNoteController::class, 'store'])->name('patients.notes.store');
    });

    // Appointments
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
        Route::post('/{appointment}/complete', [AppointmentController::class, 'markAsCompleted'])->name('appointments.markCompleted');
        Route::post('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::post('/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
    });

    // Prescriptions
    Route::prefix('prescriptions')->group(function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('prescriptions.index');
        Route::get('/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
        Route::post('/', [PrescriptionController::class, 'store'])->name('prescriptions.store');
        Route::get('/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
        Route::get('/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('prescriptions.edit');
        Route::put('/{prescription}', [PrescriptionController::class, 'update'])->name('prescriptions.update');
        Route::delete('/{prescription}', [PrescriptionController::class, 'destroy'])->name('prescriptions.destroy');
    });

    // Settings
    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Prescription Items
    Route::prefix('prescription-items')->name('prescription-items.')->group(function () {
        Route::put('/{id}', [PrescriptionItemController::class, 'update'])->name('update');
        Route::delete('/{id}', [PrescriptionItemController::class, 'destroy'])->name('destroy');
    });

    // Payments
    Route::resource('payments', PaymentController::class)->names('payments');

    // Medications
    Route::resource('medications', MedicationController::class)->names('medications');
});

// Pharmacist Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/pharmacist/dashboard', [PharmacistDashboardController::class, 'index'])->name('dashboard.pharmacist');
});

require __DIR__ . '/auth.php';
