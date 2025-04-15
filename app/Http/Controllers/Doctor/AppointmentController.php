<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // Show all appointments for the doctor
    public function index()
    {
        $doctor = Auth::user(); // Get the currently authenticated doctor (from the users table)
        
            $appointments = Appointment::all(); // Or filter by doctor if needed
            return view('dashboard.doctor.appointments.index', compact('appointments'));
        }

    // Show form to create a new appointment
    public function create()
    {
        $patients = Patient::all(); // You can use this to populate a dropdown with patients
        return view('dashboard.doctor.appointments.create', compact('patients'));
    }

    // Store a newly created appointment
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'time' => 'required|time',
        ]);

        Appointment::create($request->all());
        return redirect()->route('dashboard.doctor.appointments.index');
    }

    // Show a specific appointment's details
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

    // Update a specific appointment
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'time' => 'required|time',
        ]);

        $appointment->update($request->all());
        return redirect()->route('dashboard.doctor.appointments.index');
    }

    // Delete a specific appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('dashboard.doctor.appointments.index');
    }
}