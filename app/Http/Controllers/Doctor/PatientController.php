<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user();
    
        $patients = Patient::query()
            ->when($request->search, function($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                      ->orWhere('medical_history', 'like', '%'.$request->search.'%');
            })
            ->paginate(10);
    
        return view('dashboard.doctor.patients.index', compact('patients'));
    }

    public function create()
    {
        $statuses = ['Under Treatment', 'Recovered'];
        return view('dashboard.doctor.patients.create', compact('statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'medical_history' => 'nullable|string',
            'blood_group' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'condition' => 'nullable|string',
            'condition_status' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);
        $validatedData['doctor_id'] = Auth::id();
        
        $patient = Patient::create($validatedData);
    }
    

    public function show($id)
    {
        $patient = Patient::with('prescriptions')->findOrFail($id);
    
        return view('dashboard.doctor.patients.show', compact('patient'));
    }
    public function edit(Patient $patient)
    {
        $statuses = ['Under Treatment', 'Recovered'];
        return view('dashboard.doctor.patients.edit', compact('patient', 'statuses'));
    }

    public function update(Request $request, Patient $patient)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'required|integer',
        'medical_history' => 'nullable|string',
        'blood_group' => 'nullable|string|max:10',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'condition' => 'nullable|string|max:255',
        'condition_status' => 'nullable|string|max:255',
        'allergies' => 'nullable|string|max:255',
    ]);

    // Update the fields manually
    $patient->name = $request->name;
    $patient->age = $request->age;
    $patient->medical_history = $request->medical_history;
    $patient->blood_group = $request->blood_group;
    $patient->phone = $request->phone;
    $patient->address = $request->address;
    $patient->condition = $request->condition;
    $patient->condition_status = $request->condition_status;
    $patient->allergies = $request->allergies;

    $patient->save(); // VERY IMPORTANT!!!

    return redirect()->route('dashboard.doctor.patients.index')->with('success', 'Patient updated successfully.');
}



    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('dashboard.doctor.patients.index')->with('success', 'Patient deleted successfully.');
    }
}
