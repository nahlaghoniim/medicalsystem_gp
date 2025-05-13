<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;

class MedicationController extends Controller
{
    public function index()
    {
        return response()->json(Medication::all());
    }

    public function show(Medication $medication)
    {
        return response()->json($medication);
    }
    public function search(Request $request)
{
    $query = $request->input('query');

    if (!$query) {
        return response()->json(['message' => 'No search query provided.'], 400);
    }

    $medications = Medication::where('name', 'like', '%' . $query . '%')->get();

    return response()->json($medications);
}

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:medications,name',
            'generic_name' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'description' => 'nullable|string',
            'dosage_form' => 'nullable|string',
            'strength' => 'nullable|string',
        ]);

        $medication = Medication::create($data);
        return response()->json($medication, 201);
    }

    public function update(Request $request, Medication $medication)
    {
        $data = $request->validate([
            'name' => 'string|unique:medications,name,' . $medication->id,
            'generic_name' => 'nullable|string',
            'manufacturer' => 'nullable|string',
            'description' => 'nullable|string',
            'dosage_form' => 'nullable|string',
            'strength' => 'nullable|string',
        ]);

        $medication->update($data);
        return response()->json($medication);
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
