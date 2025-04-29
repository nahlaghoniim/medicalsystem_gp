<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
{
    $doctor = Auth::user();

    // Total number of patients assigned to this doctor
    $patientsCount = Patient::where('doctor_id', $doctor->id)->count();

    // Today's date
    $today = Carbon::today();

    // Appointments for today for this doctor
    $todayAppointments = Appointment::where('doctor_id', $doctor->id)
        ->whereDate('appointment_time', $today)
        ->with('patient')
        ->get();

    // New patients registered today assigned to this doctor
    $newPatientsToday = Patient::where('doctor_id', $doctor->id)
        ->whereDate('created_at', $today)
        ->count();

    // Total payments from this doctor's appointments
    $totalPayments = Appointment::where('doctor_id', $doctor->id)
        ->sum('payment_amount');

    // First upcoming appointment (after now)
    $upcomingAppointment = Appointment::where('doctor_id', $doctor->id)
        ->where('appointment_time', '>', now())
        ->with('patient')
        ->orderBy('appointment_time')
        ->first();

    return view('dashboard.doctor.doctor', compact(
        'doctor',
        'patientsCount',
        'todayAppointments',
        'newPatientsToday',
        'totalPayments',
        'upcomingAppointment'
    ));
}
}