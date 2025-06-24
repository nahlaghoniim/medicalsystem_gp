<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Message; // ✅ Add this line

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
public function allPatients()
{
    $patients = \App\Models\Patient::with('prescriptions')->orderBy('name')->get();

    return view('pharmacist.patients.index', compact('patients'));
}
public function messages()
{
    $messages = Message::orderBy('created_at', 'desc')->get();
    return view('pharmacist.messages.index', compact('messages'));
}

public function toggleMessageStatus($id)
{
    $message = Message::findOrFail($id);
    $message->is_read = !$message->is_read;
    $message->save();

    return back()->with('success', 'Message status updated.');
}
 
public function allPrescriptions()
{
    $prescriptions = Prescription::with(['doctor', 'patient', 'items.medication'])
        ->orderBy('created_at', 'desc')
        ->get();

    return view('pharmacist.prescriptions.index', compact('prescriptions'));
}
public function settings()
{
    $pharmacist = auth()->user();
    $setting = $pharmacist->setting;

    return view('pharmacist.settings.index', compact('pharmacist', 'setting'));
}

public function updateSettings(Request $request)
{
    $request->validate([
        'clinic_address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'notifications' => 'nullable|array',
    ]);

    $pharmacist = auth()->user();
    $setting = $pharmacist->setting;

    if (!$setting) {
        // Create settings if not exists
        $setting = new \App\Models\Setting();
        $setting->user_id = $pharmacist->id;
    }

    $setting->clinic_address = $request->clinic_address;
    $setting->phone = $request->phone;
    $setting->notifications = json_encode($request->notifications);
    $setting->save();

    return back()->with('success', 'Settings updated successfully.');
}
}
