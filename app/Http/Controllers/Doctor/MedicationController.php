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
    public function show($id)
    {
        abort(404); // or return a dummy response if needed
    }
    
   
    public function search(Request $request)
{
    $query = $request->input('q');

    $medications = Medication::where('name', 'like', '%' . $query . '%')
        ->orWhere('generic_name', 'like', '%' . $query . '%')
        ->limit(10)
        ->get();

    // Return partial HTML if it's NOT an AJAX request
    if (!$request->ajax()) {
        return view('dashboard.doctor.partials.search_results', compact('medications'));
    }

    return response()->json($medications);
}

    


     // Add show, edit, update, destroy methods as needed
}
