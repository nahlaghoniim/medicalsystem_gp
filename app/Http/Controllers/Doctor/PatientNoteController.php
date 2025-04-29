<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;

class PatientNoteController extends Controller
{
    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);

        // Assuming you have a 'notes' column or a separate table
        $patient->notes()->create([
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Note added successfully.');
    }
}
