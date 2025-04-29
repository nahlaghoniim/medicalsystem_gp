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
   // PrescriptionController.php
public function index()
{
    $prescriptions = Prescription::with('patient')->get();

    return view('dashboard.doctor.prescriptions.index', compact('prescriptions'));
}
// << You forgot this closing bracket

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'medications' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        // Step 1: Save the main prescription
        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => Auth::id(), // Get the current logged-in doctor
            'issued_at' => Carbon::now(), // Current date and time
            'is_active' => true,
            'notes' => $request->notes,
        ]);

        // Step 2: Save the prescription items
        $medications = explode("\n", $request->medications);

        foreach ($medications as $medication) {
            $medicationParts = explode('-', $medication);

            if (count($medicationParts) >= 2) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_name' => trim($medicationParts[0]),
                    'dosage' => trim($medicationParts[1]),
                    'duration_days' => 5, // Default to 5 days, or change if you want
                ]);
            }
        }

        // Step 3: Save history
        PrescriptionHistory::create([
            'prescription_id' => $prescription->id,
            'pharmacist_id' => Auth::id(), // Adjusted to pharmacist_id
        ]);

        // Step 4: Redirect properly
        return redirect()->route('dashboard.doctor.prescriptions.index')
                         ->with('success', 'Prescription created successfully.');
    }
}
