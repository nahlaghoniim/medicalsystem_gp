<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;

class EmergencyAccessController extends Controller
{
    public function show($token)
    {
        // Find the patient by their emergency token
        $patient = Patient::where('emergency_token', $token)->first();
    
        // If no patient is found, return a Blade view with an error message
        if (!$patient) {
            return view('emergency.show', ['message' => 'Invalid or expired emergency token.']);
        }
    
        // If a patient is found, return the data to the Blade view
        return view('emergency.show', [
            'name' => $patient->name,
            'age' => $patient->age,
            'blood_group' => $patient->blood_group,
            'allergies' => $patient->allergies,
            'medical_conditions' => $patient->medical_conditions,
            'emergency_contact_name' => $patient->emergency_contact_name,
            'emergency_contact_phone' => $patient->emergency_contact_phone,
            'condition' => $patient->condition,
            'condition_status' => $patient->condition_status,
        ]);
    }
    
}
