<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth Controllers
use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    RegisteredUserController,
    SocialController
};

// Shared Controllers
use App\Http\Controllers\ProfileController;

// Doctor Controllers
use App\Http\Controllers\Doctor\{
    DashboardController,
    PrescriptionController,
    PrescriptionItemController,
    PatientController,
    AppointmentController,
    PatientNoteController,
    PaymentController,
    MedicationController,
    SettingController,
    MessageController
};

// Pharmacist Controllers
use App\Http\Controllers\Pharmacist\PharmacistDashboardController;

Route::get('/', fn() => view('welcome'))->name('home');


// =====================
// 🔐 Auth Routes
// =====================
Route::middleware('guest')->group(function () {
    // Login / Register
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    // Role Selection
    Route::get('/register/role', [RegisteredUserController::class, 'selectRole'])->name('role.select');
    Route::post('/register/role', [RegisteredUserController::class, 'saveRole'])->name('role.save');

    // Social Login
    Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback']);
    Route::get('auth/facebook', [SocialController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('auth/facebook/callback', [SocialController::class, 'handleFacebookCallback']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// =====================
// 👤 Profile
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// =====================
// 🩺 Doctor Routes
// =====================
Route::middleware(['auth', 'verified', 'doctor'])
    ->prefix('doctor/dashboard')
    ->name('dashboard.doctor.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // =====================
        // 👤 Patients
        // =====================
        Route::prefix('patients')->name('patients.')->group(function () {
            Route::get('/', [PatientController::class, 'index'])->name('index');
            Route::get('/create', [PatientController::class, 'create'])->name('create');
            Route::post('/', [PatientController::class, 'store'])->name('store');
            Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('edit');
            Route::put('/{patient}', [PatientController::class, 'update'])->name('update');
            Route::get('/{patient}', [PatientController::class, 'show'])->name('show');
            Route::delete('/{patient}', [PatientController::class, 'destroy'])->name('destroy');
    Route::post('/{patient}/rays', [\App\Http\Controllers\RayController::class, 'store'])->name('rays.store');
Route::delete('/{patient}/rays/{ray}', [\App\Http\Controllers\RayController::class, 'destroy'])->name('rays.destroy');

            Route::post('/{patient}/notes', [PatientNoteController::class, 'store'])->name('notes.store');

            // Prescriptions under patient
            Route::get('/{patient}/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
            Route::get('/{patient}/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
            Route::post('/{patient}/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
            Route::get('/{patient}/prescriptions/{prescription}/qr', [PrescriptionController::class, 'generateQr'])->name('prescriptions.qr');
            Route::get('/{patient}/prescriptions/{prescription}/pdf', [PrescriptionController::class, 'generatePdf'])->name('prescriptions.pdf');
        });

        // =====================
        // 💊 Global Prescriptions
        // =====================
        Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
            Route::get('/', [PrescriptionController::class, 'index'])->name('index');
            Route::get('/{prescription}', [PrescriptionController::class, 'show'])->name('show');
            Route::get('/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('edit');
            Route::put('/{prescription}', [PrescriptionController::class, 'update'])->name('update');
            Route::delete('/{prescription}', [PrescriptionController::class, 'destroy'])->name('destroy');
        });

        // =====================
        // 📅 Appointments
        // =====================
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

            // ✅ Payment Mark as Paid
            Route::post('/{appointment}/mark-paid', [PaymentController::class, 'markPaid'])->name('markPaid');
        });

        // =====================
        // 💊 Prescription Items
        // =====================
        Route::prefix('prescription-items')->name('prescription-items.')->group(function () {
            Route::put('/{id}', [PrescriptionItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [PrescriptionItemController::class, 'destroy'])->name('destroy');
        });

        // =====================
        // ⚙️ Settings
        // =====================
        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        // =====================
        // 💵 Payments & Medications
        // =====================
        Route::resource('payments', PaymentController::class)->names('payments');
        Route::resource('medications', MedicationController::class)->only(['index'])->names('medications');
        Route::get('medications/search', [MedicationController::class, 'search'])->name('medications.search');

        // =====================
        // 💬 Messages
        // =====================
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [MessageController::class, 'index'])->name('index');
            Route::get('/{id}', [MessageController::class, 'show'])->name('show');
            Route::delete('/{id}', [MessageController::class, 'destroy'])->name('destroy');
        });
    });

// =====================
// 💊 Pharmacist Routes
// =====================
Route::middleware(['auth', 'verified', 'pharmacist'])
    ->prefix('pharmacist/dashboard')
    ->name('dashboard.pharmacist.')
    ->group(function () {

        Route::get('/', [PharmacistDashboardController::class, 'index'])->name('index');
        Route::get('/prescriptions', [PharmacistDashboardController::class, 'allPrescriptions'])->name('prescriptions.all');
        Route::get('/patients', [PharmacistDashboardController::class, 'allPatients'])->name('patients.index');
        Route::get('/patients/search', [PharmacistDashboardController::class, 'search'])->name('patients.search');
        Route::get('/patients/{id}', [PharmacistDashboardController::class, 'viewPatient'])->name('patients.view');

        // Search Form
        Route::get('/patient-search', [PharmacistDashboardController::class, 'showSearchForm'])->name('patient.search.form');
        Route::post('/patient-search', [PharmacistDashboardController::class, 'searchPatient'])->name('patient.search.submit');

        Route::post('prescription/{id}/complete', [PharmacistDashboardController::class, 'completePrescription'])->name('pharmacist.prescription.complete');

        // Scan Page
        Route::get('/scan', fn() => view('pharmacist.scan'))->name('scan');

        // Messages
        Route::prefix('messages')->name('messages.')->group(function () {
            Route::get('/', [PharmacistDashboardController::class, 'messages'])->name('index');
            Route::post('/{id}/toggle', [PharmacistDashboardController::class, 'toggleMessageStatus'])->name('toggle');
        });

        // Settings
        Route::get('/settings', [PharmacistDashboardController::class, 'settings'])->name('settings');
        Route::post('/settings', [PharmacistDashboardController::class, 'updateSettings'])->name('settings.update');
    });


// =====================
// 🧑‍💻 Dashboard fallback
// =====================
Route::get('/dashboard/{id}', function ($id) {
    $user = Auth::user();
    if (!$user || $user->id != $id) {
        abort(403);
    }
    return view('dashboard', compact('user'));
})->middleware(['auth', 'verified'])->name('dashboard.user');
