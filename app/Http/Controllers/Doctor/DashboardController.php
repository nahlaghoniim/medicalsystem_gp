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

        // Counts
        $patientsCount = Patient::where('doctor_id', $doctorId)->count();
        $appointmentsTodayCount = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_time', Carbon::today())
            ->count();
        $newPatientsToday = Patient::where('doctor_id', $doctorId)
            ->whereDate('created_at', Carbon::today())
            ->count();
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
            ->toArray(); // Important: convert to plain array for Blade/JS

        // Financial Summary
        $totalPayments = Payment::whereHas('appointment', function ($query) use ($doctorId) {
            $query->where('doctor_id', $doctorId);
        })
        ->where('status', 'paid')
        ->sum('amount');

        $revenue = $totalPayments;

        // Dummy Chart Data (replace with real logic)
        $activityLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
        $activityData = [5, 10, 3, 7, 2];

        // Return view
        return view('dashboard.doctor.doctor', compact(
            'patientsCount',
            'appointmentsTodayCount',
            'newPatientsToday',
            'todayAppointments',
            'totalPayments',
            'revenue',
            'calendarAppointments',
            'activityLabels',
            'activityData',
            'prescriptionsCount',
            'upcomingAppointment'
        ));
    }
}
