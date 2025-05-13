<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Models\PatientNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientNoteController extends Controller
{
    public function index()
    {
        $notes = PatientNote::where('doctor_id', Auth::id())->with('patient')->get();
        return response()->json($notes);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'note' => 'required|string',
        ]);

        $note = PatientNote::create([
            'doctor_id' => Auth::id(),
            'patient_id' => $data['patient_id'],
            'note' => $data['note'],
        ]);

        return response()->json($note, 201);
    }

    public function show(PatientNote $patientNote)
    {
        $this->authorizeAccess($patientNote);
        return response()->json($patientNote);
    }

    public function update(Request $request, PatientNote $patientNote)
    {
        $this->authorizeAccess($patientNote);

        $data = $request->validate([
            'note' => 'required|string',
        ]);

        $patientNote->update($data);
        return response()->json($patientNote);
    }

    public function destroy(PatientNote $patientNote)
    {
        $this->authorizeAccess($patientNote);
        $patientNote->delete();
        return response()->json(['message' => 'Deleted']);
    }

    private function authorizeAccess(PatientNote $note)
    {
        if ($note->doctor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
