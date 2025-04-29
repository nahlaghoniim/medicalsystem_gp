<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Doctor\PrescriptionController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Doctor\DashboardController; // Import the Doctor Dashboard Controller
use App\Http\Controllers\Pharmacist\DashboardController as PharmacistDashboardController; // Import the Pharmacist Dashboard Controller
use App\Http\Controllers\Doctor\PatientController; // Import the Patient Controller for the doctor
use App\Http\Controllers\Doctor\AppointmentController; // Import the Appointment Controller for the doctor
use Illuminate\Support\Facades\Auth; // Import Auth for authentication routes
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Doctor\PatientNoteController;



/*
|---------------------------------------------------------------------- 
| Web Routes
|---------------------------------------------------------------------- 
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

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

// Doctor Routes (Patient Management and Dashboard)
   // Doctor Routes (Patient Management and Dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    // Doctor Dashboard Route
    Route::get('/doctor/dashboard', [DashboardController::class, 'index'])->name('dashboard.doctor');

    // Patient Routes for Doctor
Route::prefix('doctor/dashboard/patients')->group(function () {
    Route::get('/', [PatientController::class, 'index'])->name('dashboard.doctor.patients.index');
    Route::get('/create', [PatientController::class, 'create'])->name('dashboard.doctor.patients.create');
    Route::post('/', [PatientController::class, 'store'])->name('dashboard.doctor.patients.store');
    Route::get('/{patient}/edit', [PatientController::class, 'edit'])->name('dashboard.doctor.patients.edit');
    Route::put('/{patient}', [PatientController::class, 'update'])->name('dashboard.doctor.patients.update');
    Route::get('/{patient}', [PatientController::class, 'show'])->name('dashboard.doctor.patients.show');
    
Route::prefix('doctor/dashboard')->name('dashboard.doctor.')->group(function () {
    Route::post('patients/{patient}/notes', [PatientNoteController::class, 'store'])->name('patients.notes.store');
});
});


    // Appointment Routes for Doctor under 'dashboard/doctor/appointments' folder
    Route::prefix('doctor/dashboard/appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('dashboard.doctor.appointments.index'); // View all appointments
        Route::get('/create', [AppointmentController::class, 'create'])->name('dashboard.doctor.appointments.create'); // Show form to create a new appointment
        Route::post('/', [AppointmentController::class, 'store'])->name('dashboard.doctor.appointments.store'); // Store the new appointment
        Route::get('/{appointment}/edit', [AppointmentController::class, 'edit'])->name('dashboard.doctor.appointments.edit'); // Show form to edit appointment
        Route::put('/{appointment}', [AppointmentController::class, 'update'])->name('dashboard.doctor.appointments.update'); // Update the appointment
        Route::get('/{appointment}', [AppointmentController::class, 'show'])->name('dashboard.doctor.appointments.show'); // Show details of a single appointment
    });

    Route::prefix('prescriptions')->group(function () {
        Route::get('/', [PrescriptionController::class, 'index'])->name('dashboard.doctor.prescriptions.index');
        Route::get('/create', [PrescriptionController::class, 'create'])->name('dashboard.doctor.prescriptions.create');
        Route::post('/', [PrescriptionController::class, 'store'])->name('dashboard.doctor.prescriptions.store');
        Route::get('/{id}', [PrescriptionController::class, 'show'])->name('dashboard.doctor.prescriptions.show');
    });
    


});
// Pharmacist Routes (Dashboard)
Route::middleware(['auth', 'verified'])->group(function () {
    // Pharmacist Dashboard Route
    Route::get('/pharmacist/dashboard', [PharmacistDashboardController::class, 'index'])->name('dashboard.pharmacist');
});

require __DIR__.'/auth.php';

