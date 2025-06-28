<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session; // add this at the top if not already

use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user();

        $patients = Patient::where('doctor_id', $doctor->id)
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('medical_history', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate(10);

        return response()->json($patients);
    }

   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'age' => 'required|integer',
        'medical_history' => 'nullable|string',
        'blood_group' => 'nullable|string|max:10',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'condition' => 'nullable|string',
        'condition_status' => 'nullable|string',
        'allergies' => 'nullable|string',
        'emergency_contact_name' => 'nullable|string|max:255',
        'emergency_contact_phone' => 'nullable|string|max:20',
        'medical_conditions' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'fail',
            'errors' => $validator->errors()
        ], 422);
    }

    $data = $validator->validated();
    $data['doctor_id'] = Auth::id();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('uploads', 'public');
    }

    $patient = Patient::create($data);

    // 🔹 Increment new patients count in session
    Session::put('new_patients_today_count', Session::get('new_patients_today_count', 5) + 1);

    return response()->json([
        'status' => 'success',
        'message' => 'Patient created successfully.',
        'data' => $patient
    ], 201);
}


    public function show($id)
    {
        $patient = Patient::with('prescriptions')->find($id);

        if (!$patient || $patient->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Patient not found.'], 404);
        }

        return response()->json($patient);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (!$patient || $patient->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Patient not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'medical_history' => 'nullable|string',
            'blood_group' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'condition' => 'nullable|string',
            'condition_status' => 'nullable|string',
            'allergies' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_conditions' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validator->errors()
            ], 422);
        }

        $patient->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Patient updated successfully.',
            'data' => $patient
        ]);
    }

    public function destroy($id)
    {
        $patient = Patient::find($id);

        if (!$patient || $patient->doctor_id !== Auth::id()) {
            return response()->json(['message' => 'Patient not found.'], 404);
        }

        $patient->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Patient deleted successfully.'
        ]);
    }
}
