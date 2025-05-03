<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PrescriptionHistory;
use App\Models\Medication;
use App\Models\Patient;

class PrescriptionController extends Controller
{
    // Display all prescriptions
    public function index()
    {
        $prescriptions = Prescription::with('patient')->latest()->get();
        $patients = Patient::all();

        return view('dashboard.doctor.prescriptions.index', compact('prescriptions', 'patients'));
    }

    // Show form to create a prescription for a specific patient
    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $medications = Medication::orderBy('name')->get(); // optional: for dropdown
        return view('dashboard.doctor.prescriptions.create', compact('patient', 'medications'));
    }

    // Store a new prescription
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'medications' => 'required|array',
            'medications.*.medicine_name' => 'required|string',
            'medications.*.dosage' => 'required|string',
            'medications.*.duration_days' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $patientId,
            'doctor_id' => Auth::id(),
            'issued_at' => Carbon::now(),
            'is_active' => true,
            'notes' => $request->notes,
        ]);

        foreach ($request->medications as $item) {
            $prescription->items()->create([
                'medicine_name' => $item['medicine_name'],
                'dosage' => $item['dosage'],
                'duration_days' => $item['duration_days'],
            ]);
        }

        // Create prescription history record
        PrescriptionHistory::create([
            'prescription_id' => $prescription->id,
            'pharmacist_id' => null, // Optional: change if needed
        ]);

        return redirect()->route('dashboard.doctor.patients.show', $patientId)
                         ->with('success', 'Prescription created successfully.');
    }

    // Show a specific prescription
    public function show($id)
    {
        $prescription = Prescription::with('patient', 'items')->findOrFail($id);
        return view('dashboard.doctor.prescriptions.show', compact('prescription'));
    }

    // Edit prescription form
    public function edit(Prescription $prescription)
    {
        return view('dashboard.doctor.prescriptions.edit', compact('prescription'));
    }

    // Update a prescription item
    public function update(Request $request, $id)
    {
        $item = PrescriptionItem::findOrFail($id);

        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'duration_days' => 'required|integer',
        ]);

        $item->update([
            'medicine_name' => $request->medicine_name,
            'dosage' => $request->dosage,
            'duration_days' => $request->duration_days,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Updated successfully']);
        }

        return redirect()->route('dashboard.doctor.patients.show', $item->prescription->patient_id)
                         ->with('success', 'Prescription item updated successfully.');
    }

    // Delete a prescription item
    public function destroy(Request $request, $id)
    {
        $item = PrescriptionItem::findOrFail($id);
        $patientId = $item->prescription->patient_id;

        $item->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Deleted successfully']);
        }

        return redirect()->route('dashboard.doctor.patients.show', $patientId)
                         ->with('success', 'Prescription item deleted successfully.');
    }
}