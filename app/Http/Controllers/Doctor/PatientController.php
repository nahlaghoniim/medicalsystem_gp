<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    // View the list of patients for the doctor
    public function index()
    {
        $doctor = Auth::user();
        $patients = Patient::all(); // Or filter by doctor if needed
        return view('dashboard.doctor.patients.index', compact('patients'));
    }

     // Show form to create a new patient
     public function create()
     {
         return view('dashboard.doctor.patients.create');
     }
 
     // Store a newly created patient
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|string',
             'age' => 'required|integer',
             'medical_history' => 'nullable|string',
         ]);
 
         $patient = Patient::create($request->all());
         return redirect()->route('dashboard.doctor.patients.index');
     }
 
     // Show a specific patient's details
     public function show(Patient $patient)
     {
         return view('dashboard.doctor.patients.show', compact('patient'));
     }
 
     // Show the form to edit a patient
     public function edit(Patient $patient)
     {
         return view('dashboard.doctor.patients.edit', compact('patient'));
     }
 
     // Update a specific patient's details
     public function update(Request $request, Patient $patient)
     {
         $request->validate([
             'name' => 'required|string',
             'age' => 'required|integer',
             'medical_history' => 'nullable|string',
         ]);
 
         $patient->update($request->all());
         return redirect()->route('dashboard.doctor.patients.index');
     }
 
     // Delete a patient
     public function destroy(Patient $patient)
     {
         $patient->delete();
         return redirect()->route('dashboard.doctor.patients.index');
     }
 }