<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::paginate(1000); // or any number you prefer
        return view('dashboard.doctor.medications.index', compact('medications'));
    }

    public function create()
    {
        return view('dashboard.doctor.medications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'dosage_form' => 'nullable|string|max:255',
            'strength' => 'nullable|string|max:255',
        ]);

        Medication::create($validated);
        return redirect()->route('dashboard.doctor.medications.index')->with('success', 'Medication added.');
    }

    // Add show, edit, update, destroy methods as needed
}
