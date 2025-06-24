<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\RoleSelectionController;

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
use App\Http\Controllers\Pharmacist\PharmacistDashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Social Login
Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);

// Guest Routes (Login/Register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/register/role', [RegisteredUserController::class, 'selectRole'])->name('role.select');
    Route::post('/register/role', [RegisteredUserController::class, 'saveRole'])->name('role.save');
});

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Dashboard fallback
Route::get('/dashboard/{id}', function ($id) {
    $user = Auth::user();
    if (!$user || $user->id != $id) {
        abort(403);
    }
    return view('dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard.user');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Doctor Routes
Route::middleware(['auth', 'verified', 'doctor'])
    ->prefix('doctor/dashboard')
    ->name('dashboard.doctor.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // Patients
        Route::prefix('patients')->name('patients.')->group(function () {
            Route::get('/', [PatientController::class, 'index'])->name('index');
            Route::get('/create', [PatientController::class, 'create'])->name('create');
            Route::post('/', [PatientController::class, 'store'])->name('store');
            Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('edit');
            Route::put('/{patient}', [PatientController::class, 'update'])->name('update');
            Route::get('/{patient}', [PatientController::class, 'show'])->name('show');
            Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('destroy');

            // Notes
            Route::post('/{patient}/notes', [PatientNoteController::class, 'store'])->name('notes.store');

            // Prescriptions under patient
            Route::get('/{patient}/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
            Route::get('/{patient}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
            Route::post('/{patient}/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');

            // Generate PDF for prescriptions of a patient
            Route::get('/{patient}/prescriptions/pdf', [PrescriptionController::class, 'generatePdf'])->name('prescriptions.pdf');

            // Generate QR for a specific prescription of a patient
            Route::get('/{patient}/prescriptions/{prescription}/qr', [PrescriptionController::class, 'generateQr'])->name('prescriptions.qr');
        });

        // Prescriptions CRUD (not patient-specific)
        Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
            Route::get('/', [PrescriptionController::class, 'index'])->name('index');
            Route::get('/{prescription}', [PrescriptionController::class, 'show'])->name('show');
            Route::get('/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('edit');
            Route::put('/{prescription}', [PrescriptionController::class, 'update'])->name('update');
            Route::delete('/{prescription}', [PrescriptionController::class, 'destroy'])->name('destroy');
        });

        // Appointments
        Route::prefix('appointments')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::get('/create', [AppointmentController::class, 'create'])->name('create');
            Route::post('/', [AppointmentController::class, 'store'])->name('store');
            Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('edit');
            Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('update');
            Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('show');
            Route::post('/{appointment}/complete', [AppointmentController::class, 'markAsCompleted'])->name('markCompleted');
            Route::post('/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('cancel');
            Route::post('/{appointment}/reschedule', [AppointmentController::class, 'reschedule'])->name('reschedule');
        });

        // Prescription Items
        Route::prefix('prescription-items')->name('prescription-items.')->group(function () {
            Route::put('/{id}', [PrescriptionItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrescriptionItemController::class, 'destroy'])->name('destroy');
        });

        // Settings
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        // Payments
        Route::resource('payments', PaymentController::class)->names('payments');

        // Medications
        Route::resource('medications', MedicationController::class)->only(['index'])->names('medications');
        Route::get('medications/search', [MedicationController::class, 'search'])->name('medications.search');
    });
// Pharmacist Routes
Route::middleware(['auth', 'verified', 'pharmacist'])
    ->prefix('pharmacist/dashboard')
    ->name('dashboard.pharmacist.')
    ->group(function () {

        // Dashboard Home
        Route::get('/', [PharmacistDashboardController::class, 'index'])->name('index');

        // Search for patients by ID or name (quick search or listing page)
        Route::get('/patients/search', [PharmacistDashboardController::class, 'search'])->name('patients.search');

        // View single patient's prescriptions
        Route::get('/patients/{id}', [PharmacistDashboardController::class, 'viewPatient'])->name('patients.view');

        // Show form to enter patient credentials (new flow)
        Route::get('/patient-search', [PharmacistDashboardController::class, 'showSearchForm'])->name('patient.search.form');

        // Handle patient search form submission
        Route::post('/patient-search', [PharmacistDashboardController::class, 'searchPatient'])->name('patient.search.submit');

        // ✅ Correct prescription complete route
        Route::post('prescription/{id}/complete', [PharmacistDashboardController::class, 'completePrescription'])->name('pharmacist.prescription.complete');
   Route::get('/scan', function () {
    return view('pharmacist.scan');
})->name('scan');

   
    });
