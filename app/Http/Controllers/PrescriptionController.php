<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PrescriptionHistory;

class PrescriptionController extends Controller


{
    // Show all prescriptions
    public function index()
{
    $prescriptions = Prescription::paginate(10);
    return view('dashboard.doctor.prescriptions.index', compact('prescriptions'));
}

    // Show create form
    public function create()
    {
        return view('dashboard.doctor.prescriptions.create');
    }

    // Store new prescription
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'issued_at' => 'required|date',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.duration_days' => 'required|integer',
        ]);

        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'issued_at' => $request->issued_at,
            'is_active' => true,
        ]);

        foreach ($request->medicines as $medicine) {
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medicine_name' => $medicine['name'],
                'dosage' => $medicine['dosage'],
                'duration_days' => $medicine['duration_days'],
            ]);
        }

        // Save to history
        PrescriptionHistory::create([
            'prescription_id' => $prescription->id,
            'changed_by' => $request->doctor_id,
            'change_type' => 'created',
        ]);

        return redirect()->route('prescriptions.index')->with('success', 'Prescription created successfully.');
    }

    // Show one prescription
    public function show($id)
    {
        $prescription = Prescription::with('items')->findOrFail($id);
        return view('prescriptions.show', compact('prescription'));
    }

    // Other methods like edit, update, destroy can be added later
}