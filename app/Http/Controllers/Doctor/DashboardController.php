<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $doctorId = Auth::id();
 $totalPayments = Payment::whereHas('appointment', function ($query) use ($doctorId) {
        $query->where('doctor_id', $doctorId);
    })->sum('amount');
    // Counts
    $patientsCount = Patient::where('doctor_id', $doctorId)->count();
    $appointmentsTodayCount = Appointment::where('doctor_id', $doctorId)
        ->whereDate('appointment_time', Carbon::today())
        ->count();
   // Get actual count of new patients today from DB
$realNewPatientsToday = Patient::where('doctor_id', $doctorId)
    ->whereDate('created_at', Carbon::today())
    ->count();

// Set default static base (e.g. 5), or use session if it exists
$baseStatic = 5;
$newPatientsToday = session('new_patients_today_count', $baseStatic);

// If real count exceeds current session value, sync it up
if ($realNewPatientsToday > $newPatientsToday) {
    $newPatientsToday = $realNewPatientsToday;
    session(['new_patients_today_count' => $newPatientsToday]);
}

    $prescriptionsCount = Prescription::where('doctor_id', $doctorId)->count();

    // Appointments
    $todayAppointments = Appointment::with('patient')
        ->where('doctor_id', $doctorId)
        ->whereDate('appointment_time', Carbon::today())
        ->get();

    $upcomingAppointment = Appointment::with('patient')
        ->where('doctor_id', $doctorId)
        ->where('appointment_time', '>', now())
        ->orderBy('appointment_time')
        ->first();

    // Calendar Events
    $calendarAppointments = Appointment::with('patient')
        ->where('doctor_id', $doctorId)
        ->get()
        ->filter(fn($a) => $a->appointment_time && $a->patient)
        ->map(function ($a) {
            return [
                'title' => $a->patient->name . ' @ ' . Carbon::parse($a->appointment_time)->format('H:i'),
                'start' => Carbon::parse($a->appointment_time)->toIso8601String(),
                'status' => $a->status ?? 'Scheduled',
            ];
        })
        ->values()
        ->toArray();

       // 🔹 Revenue summary (Total paid payments for this doctor)
       $totalPayments = Payment::whereHas('appointment', function ($query) use ($doctorId) {
        $query->where('doctor_id', $doctorId);
    })
    ->where('status', 'paid')
    ->sum('amount');

    $revenue = $totalPayments;

    // 🔹 Dynamic Chart Data for the past 7 days
    $activityLabels = [];
    $revenueData = [];
    $appointmentsData = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i);
        $activityLabels[] = $date->format('D');

        // Appointments per day
        $appointmentsData[] = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_time', $date)
            ->count();

        // Revenue per day
        $revenueData[] = Payment::whereHas('appointment', function ($query) use ($doctorId, $date) {
            $query->where('doctor_id', $doctorId)
                  ->whereDate('appointment_time', $date);
        })
        ->where('status', 'paid')
        ->sum('amount');
    }

    // 🔹 Optional: Get latest 5 payments
    $recentPayments = Payment::whereHas('appointment', function ($query) use ($doctorId) {
        $query->where('doctor_id', $doctorId);
    })->with('patient')
      ->latest()
      ->take(5)
      ->get();

    // Latest Appointments
    $latestAppointments = Appointment::where('doctor_id', $doctorId)
        ->with('patient')
        ->orderByDesc('appointment_time')
        ->take(5)
        ->get();

    // Return view with all variables
    return view('dashboard.doctor.doctor', compact(
        'patientsCount',
        'appointmentsTodayCount',
        'newPatientsToday',
        'todayAppointments',
        'totalPayments',
        'revenue',
        'calendarAppointments',
        'activityLabels',
        'revenueData',
        'appointmentsData',
        'prescriptionsCount',
        'upcomingAppointment',
        'latestAppointments'
    ));
}    
}