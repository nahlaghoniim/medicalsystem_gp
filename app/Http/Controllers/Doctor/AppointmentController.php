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

    $appointments = Appointment::where('appointments.doctor_id', $doctor->id)
        ->with(['patient', 'payment']) // ✅ Include payment
        ->when($request->search, function ($query) use ($request) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        })
        ->when($request->status, function ($query) use ($request) {
            $query->where('status', $request->status);
        })
        ->when($request->sort === 'patient', function ($query) {
            $query->join('patients', 'appointments.patient_id', '=', 'patients.id')
                  ->orderBy('patients.name')
                  ->select('appointments.*');
        }, function ($query) {
            $query->orderBy('appointment_date', 'asc');
        })
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
            'appointment_date' => 'required|date|after_or_equal:now',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);
    
        Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'appointment_date' => \Carbon\Carbon::parse($request->appointment_date),
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
    
        return redirect()->route('dashboard.doctor.appointments.index')
            ->with('success', 'Appointment created successfully.');
    }
    

    // Show a specific appointment
    public function show(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        return view('dashboard.doctor.appointments.show', compact('appointment'));
    }

    // Show the form to edit an appointment
    public function edit(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        $patients = Patient::all();
        return view('dashboard.doctor.appointments.edit', compact('appointment', 'patients'));
    }

    // Update an appointment
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
        ]);

        $appointment->update([
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard.doctor.appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    // Delete an appointment
    public function destroy(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        $appointment->delete();

        return redirect()->route('dashboard.doctor.appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    // Mark appointment as completed
    public function markAsCompleted(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        $appointment->update(['status' => 'Completed']);
        return redirect()->back()->with('success', 'Appointment marked as completed.');
    }

    // Cancel the appointment
    public function cancel(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        $appointment->update(['status' => 'Cancelled']);
        return redirect()->back()->with('success', 'Appointment cancelled.');
    }

    // Reschedule the appointment
    public function reschedule(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);

        $request->validate([
            'new_date' => 'required|date|after_or_equal:today',
        ]);

        $appointment->update([
            'appointment_date' => $request->new_date,
            'status' => 'Scheduled',
        ]);

        return redirect()->back()->with('success', 'Appointment rescheduled.');
    }

    // Return calendar data for FullCalendar
    public function calendarEvents()
    {
        $doctor = Auth::user();

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->with('patient')
            ->get()
            ->map(function ($appt) {
                return [
                    'title' => $appt->patient->name . ' (' . $appt->status . ')',
                    'start' => $appt->appointment_date,
                    'url' => route('dashboard.doctor.appointments.show', $appt),
                    'color' => $this->getStatusColor($appt->status),
                ];
            });

        return response()->json($appointments);
    }

    // Helper for color coding events
    private function getStatusColor($status)
    {
        return match ($status) {
            'Scheduled' => '#3b82f6',    // blue
            'Completed' => '#10b981',    // green
            'Cancelled' => '#ef4444',    // red
            default => '#6b7280',        // gray
        };
    }

    // Ensure only the correct doctor can access this appointment
    private function authorizeAppointment(Appointment $appointment)
    {
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
    
}
