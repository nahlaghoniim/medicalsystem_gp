<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PrescriptionHistory;

class PrescriptionController extends Controller
{
    // Display all prescriptions
    public function index()
    {
        $prescriptions = Prescription::with('patient')->get();
        return view('dashboard.doctor.prescriptions.index', compact('prescriptions'));
    }

    // Show edit form
    public function edit($id)
{
    $prescription = Prescription::with('prescriptionItems')->findOrFail($id);
    return view('dashboard.doctor.prescriptions.edit', compact('prescription'));
}

    

    // Store a new prescription
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'medications' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Save main prescription
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(),
            'issued_at' => Carbon::now(),
            'is_active' => true,
            'notes' => $request->notes,
        ]);

        // Save items
        $medications = explode("\n", $request->medications);
        foreach ($medications as $medication) {
            $parts = explode('-', $medication);
            if (count($parts) >= 2) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_name' => trim($parts[0]),
                    'dosage' => trim($parts[1]),
                    'duration_days' => 5,
                ]);
            }
        }

        // Save history
        PrescriptionHistory::create([
            'prescription_id' => $prescription->id,
            'pharmacist_id' => Auth::id(), // Update to actual pharmacist if applicable
        ]);

        return redirect()->route('dashboard.doctor.prescriptions.index')
                         ->with('success', 'Prescription created successfully.');
    }

    // DELETE a medication (prescription item)
   

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
