<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medication;
use App\Models\PrescriptionItem;

class MedicationController extends Controller
{

public function index(Request $request)
{
    $query = Medication::query();

    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('generic_name', 'like', "%{$search}%")
              ->orWhere('manufacturer', 'like', "%{$search}%");
    }

    $medications = $query->orderBy('name')->paginate(50); // 50 is cleaner than 1000

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

    // New method to update prescription items with missing medicine_id
    public function updatePrescriptionItems()
    {
        $items = PrescriptionItem::all();

        foreach ($items as $item) {
            if ($item->medicine_id === null && $item->medication_name) {
                // Adjust the column name here to 'name' in the medications table
                $med = Medication::where('name', $item->medication_name)->first();

                if ($med) {
                    $item->medicine_id = $med->id;
                    $item->save();
                    echo "Updated item ID {$item->id} to medicine ID {$med->id} - {$med->name}<br>";
                } else {
                    echo "No match for medication '{$item->medication_name}'<br>";
                }
            }
        }

        echo "Prescription items updated successfully.";
    }
}
