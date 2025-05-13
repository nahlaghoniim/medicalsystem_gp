<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    // List all appointments for the authenticated doctor
    public function index(Request $request)
    {
        $doctorId = Auth::id();

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->with(['patient', 'payment'])
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
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $appointments
        ]);
    }

    // Store a new appointment
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $data['doctor_id'] = Auth::id();
        $data['appointment_date'] = \Carbon\Carbon::parse($data['appointment_date']);

        $appointment = Appointment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Appointment created successfully.',
            'data' => $appointment
        ], 201);
    }

    // Show a specific appointment
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'payment'])
            ->where('doctor_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $appointment
        ]);
    }

    // Update an appointment
    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $appointment->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Appointment updated successfully.',
            'data' => $appointment
        ]);
    }

    // Delete an appointment
    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully.'
        ]);
    }

    // Mark the appointment as completed
    public function markAsCompleted($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointment->update(['status' => 'Completed']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment marked as completed.'
        ]);
    }

    // Cancel the appointment
    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointment->update(['status' => 'Cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled successfully.'
        ]);
    }

    // Reschedule the appointment
    public function reschedule(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'new_date' => 'required|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $appointment->update([
            'appointment_date' => \Carbon\Carbon::parse($request->new_date),
            'status' => 'Scheduled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment rescheduled successfully.',
            'data' => $appointment
        ]);
    }

    // Calendar events for FullCalendar
    public function calendarEvents()
    {
        $doctorId = Auth::id();
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->with('patient')
            ->get()
            ->map(function ($appt) {
                return [
                    'title' => $appt->patient->name . ' (' . $appt->status . ')',
                    'start' => $appt->appointment_date,
                    'color' => $this->getStatusColor($appt->status),
                ];
            });

        return response()->json([
            'success' => true,
            'events' => $appointments
        ]);
    }

    // Helper to get status color
    private function getStatusColor($status)
    {
        return match ($status) {
            'Scheduled' => '#3b82f6',
            'Completed' => '#10b981',
            'Cancelled' => '#ef4444',
            default => '#6b7280',
        };
    }
}
