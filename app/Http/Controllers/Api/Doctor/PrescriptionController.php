<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PrescriptionHistory;
use App\Models\Medication;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrescriptionController extends Controller
{
    // List all prescriptions for the authenticated doctor
    public function index()
    {
        $prescriptions = Prescription::with('patient')
            ->where('doctor_id', Auth::id())
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'prescriptions' => $prescriptions
        ]);
    }

    // Store a new prescription for a patient
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'medications' => 'required|array',
            'medications.*.medicine_name' => 'required|string',
            'medications.*.dosage' => 'required|string',
            'medications.*.duration_days' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $prescription = Prescription::create([
                'patient_id' => $patientId,
                'doctor_id' => Auth::id(),
                'issued_at' => Carbon::now(),
                'is_active' => true,
                'notes' => $request->notes,
            ]);

            foreach ($request->medications as $item) {
                $medication = Medication::where('name', $item['medicine_name'])->first();

                if ($medication) {
                    $prescription->items()->create([
                        'medicine_id' => $medication->id,
                        'dosage' => $item['dosage'],
                        'duration_days' => $item['duration_days'],
                    ]);
                } else {
                    $prescription->items()->create([
                        'medicine_name' => $item['medicine_name'], // fallback name
                        'dosage' => $item['dosage'],
                        'duration_days' => $item['duration_days'],
                    ]);
                }
            }

            PrescriptionHistory::create([
                'prescription_id' => $prescription->id,
                'pharmacist_id' => null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Prescription created successfully',
                'prescription' => $prescription->load('items')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to create prescription',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Show a specific prescription
    public function show($id)
    {
        $prescription = Prescription::with(['patient', 'items.medication'])
            ->where('doctor_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'prescription' => $prescription
        ]);
    }

    // Delete a prescription item
    public function destroyItem($id)
    {
        $item = PrescriptionItem::findOrFail($id);

        // Optional: Verify doctor owns the prescription
        if ($item->prescription->doctor_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prescription item deleted successfully'
        ]);
    }
}
