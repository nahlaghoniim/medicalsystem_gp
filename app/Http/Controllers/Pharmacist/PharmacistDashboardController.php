<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Prescription;

class PharmacistDashboardController extends Controller
{
    // Show Dashboard
    public function index()
    {
        return view('pharmacist.dashboard');
    }

    // Show Search Form
    public function showSearchForm()
    {
        return view('pharmacist.search_form'); // Blade file: resources/views/pharmacist/search_form.blade.php
    }

    // Handle Search
    public function searchPatient(Request $request)
    {
        // Validate input
        $request->validate([
            'patient_id' => 'required',
            'patient_name' => 'required',
        ]);

        // Search in database
        $patient = Patient::where('id', $request->input('patient_id'))
                        ->where('name', 'like', "%{$request->input('patient_name')}%")
                        ->first();

        if ($patient) {
            // ✅ Correct route name to redirect to patient details
            return redirect()->route('dashboard.pharmacist.patients.view', ['id' => $patient->id]);
        } else {
            return back()->with('error', 'Patient not found. Please check the ID and Name.');
        }
    }

    // View Patient Details
    public function viewPatient($id)
    {
        $patient = Patient::with([
    'prescriptions.doctor', // Ensure the doctor relation has 'specialty'
    'prescriptions.items.medication'
])->findOrFail($id);
        return view('pharmacist.patient_detail', compact('patient'));
    }
public function completePrescription($id)
{
    $prescription = Prescription::findOrFail($id);
    $prescription->status = 'Completed';
    $prescription->save();

    return back()->with('success', 'Prescription marked as completed.');
}

 
}
