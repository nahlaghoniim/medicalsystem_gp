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
        // Check if the user is authenticated
        if (Auth::check()) {
            $doctorName = Auth::user()->name;
        } else {
            // Handle the case where the doctor is not logged in
            $doctorName = 'Guest'; // Or redirect to login, depending on your app's logic
        }
    
        $appointments = Appointment::paginate(10);
    
        return view('dashboard.doctor.appointments.index', compact('appointments', 'doctorName'));
    }
    // Show form to create a new appointment
    public function create()
    {
        $patients = Patient::all(); // You can use this to populate a dropdown with patients
        return view('dashboard.doctor.appointments.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            // Add validation for any other fields if needed
        ]);
    
        // Create new appointment with logged-in doctor
        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(), // 👈 Adds the currently authenticated doctor
            'appointment_date' => $request->appointment_date,
            'status' => 'pending', // Optional if your DB already defaults it
        ]);
    
        return redirect()->route('dashboard.doctor.appointments.index')->with('success', 'Appointment created successfully!');
    }
    
    

    // Show a specific appointment's details
    public function show(Appointment $appointment)
    {
        return view('dashboard.doctor.appointments.show', compact('appointment'));
    }

    // Show the form to edit an appointment
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all(); // Fetch all patients for dropdown or selection
        return view('dashboard.doctor.appointments.edit', compact('appointment', 'patients'));
    }

    // Update a specific appointment
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
        ]);

        // Update the appointment with the new data
        $appointment->update([
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status ?? $appointment->status, // Only update status if provided
        ]);

        // Redirect back to the appointments list (index)
        return redirect()->route('dashboard.doctor.appointments.index');
    }

    // Delete a specific appointment
    public function destroy(Appointment $appointment)
    {
        // Delete the appointment
        $appointment->delete();

        // Redirect back to the appointments list (index)
        return redirect()->route('dashboard.doctor.appointments.index');
    }
}
