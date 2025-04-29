<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // View all appointments for the doctor
    public function index(Request $request)
    {
        $doctor = Auth::user();

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->when($request->search, function($query) use ($request) {
                $query->whereHas('patient', function($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->search.'%');
                });
            })
            ->orderBy('appointment_date', 'asc')
            ->paginate(10);

        return view('dashboard.doctor.appointments.index', compact('appointments'));
    }

    // Show the form to create a new appointment
    public function create()
    {
        $patients = Patient::all();
        return view('dashboard.doctor.appointments.create', compact('patients'));
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.doctor.appointments.index')->with('success', 'Appointment created successfully.');
    }

    // Show a specific appointment
    public function show(Appointment $appointment)
    {
        return view('dashboard.doctor.appointments.show', compact('appointment'));
    }

    // Show the form to edit an appointment
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();
        return view('dashboard.doctor.appointments.edit', compact('appointment', 'patients'));
    }

    // Update an appointment
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
        ]);

        return redirect()->route('dashboard.doctor.appointments.index')->with('success', 'Appointment updated successfully.');
    }

    // Delete an appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('dashboard.doctor.appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}

