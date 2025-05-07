<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\PrescriptionHistory;
use App\Models\Medication;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Patient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    // Display all prescriptions
    public function index()
    {
        $prescriptions = Prescription::with('patient')->latest()->get();
        $patients = Patient::all();

        return view('dashboard.doctor.prescriptions.index', compact('prescriptions', 'patients'));
    }

    // Show form to create a prescription for a specific patient
    public function create($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $medications = Medication::orderBy('name')->get(); // optional: for dropdown
        return view('dashboard.doctor.prescriptions.create', compact('patient', 'medications'));
    }

    // Store a new prescription
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
            // Create the new prescription
            $prescription = Prescription::create([
                'patient_id' => $patientId,
                'doctor_id' => Auth::id(),
                'issued_at' => Carbon::now(),
                'is_active' => true,
                'notes' => $request->notes,
            ]);

            // Loop through the medications and create prescription items
            foreach ($request->medications as $item) {
                // Find the medication by name
                $medication = Medication::where('name', $item['medicine_name'])->first();

                // If medication exists, create the prescription item
                if ($medication) {
                    $prescription->items()->create([
                        'medicine_id' => $medication->id,  // Store the medication ID
                        'dosage' => $item['dosage'],
                        'duration_days' => $item['duration_days'],
                    ]);
                } else {
                    // Handle case where medication is not found
                    // You could set a default value or create a placeholder, depending on your requirements
                    $prescription->items()->create([
                        'medicine_name' => 'Unknown Medication', // Default name if not found
                        'dosage' => $item['dosage'],
                        'duration_days' => $item['duration_days'],
                    ]);
                }
            }

            // Create prescription history record
            PrescriptionHistory::create([
                'prescription_id' => $prescription->id,
                'pharmacist_id' => null, // Optional: change if needed
            ]);

            DB::commit();

            // Redirect after storing the prescription
            return redirect()->route('dashboard.doctor.patients.show', $patientId)
                             ->with('success', 'Prescription created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'There was an error creating the prescription.']);
        }
    }

    // Show a specific prescription
    public function show($id)
    {
        $prescription = Prescription::with(['patient', 'items.medication'])->findOrFail($id);
        return view('dashboard.doctor.prescriptions.show', compact('prescription'));
    }

    // Edit prescription form
    public function edit(Prescription $prescription)
    {
        return view('dashboard.doctor.prescriptions.edit', compact('prescription'));
    }

    // Update a prescription item
    public function update(Request $request, $id)
    {
        $item = PrescriptionItem::findOrFail($id);

        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'duration_days' => 'required|integer',
        ]);

        $item->update([
            'medicine_name' => $request->medicine_name,
            'dosage' => $request->dosage,
            'duration_days' => $request->duration_days,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Updated successfully']);
        }

        return redirect()->route('dashboard.doctor.patients.show', $item->prescription->patient_id)
                         ->with('success', 'Prescription item updated successfully.');
    }

    // Delete a prescription item
    public function destroy(Request $request, $id)
    {
        $item = PrescriptionItem::findOrFail($id);
        $patientId = $item->prescription->patient_id;

        $item->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Deleted successfully']);
        }

        return redirect()->route('dashboard.doctor.patients.show', $patientId)
                         ->with('success', 'Prescription item deleted successfully.');
    }

    // Generate PDF for a prescription
    public function generatePdf($patientId)
    {
        // Find the patient
        $patient = Patient::findOrFail($patientId);

        // Find the prescription (load doctor and items + medication relationships)
        $prescription = $patient->prescriptions()
            ->with([
                'doctor',
                'items.medication'  // this ensures medications are eager-loaded
            ])
            ->firstOrFail();

        // Ensure 'issued_at' is a Carbon instance
        if (is_string($prescription->issued_at)) {
            $prescription->issued_at = Carbon::parse($prescription->issued_at);
        }

        // Generate QR code
        $qrCode = QrCode::size(150)->generate(route('dashboard.doctor.patients.prescriptions.qr', [
            'patient' => $patient->id,
            'prescription' => $prescription->id
        ]));

        // Generate PDF and return download
        return PDF::loadView('dashboard.doctor.prescriptions.pdf', compact('prescription', 'qrCode'))
            ->download('prescription_' . $prescription->id . '.pdf');
    }

    // Generate QR code for prescription
    public function generateQr($patientId, $prescriptionId)
    {
        // Generate QR code URL
        $prescription = Prescription::findOrFail($prescriptionId);
        $patient = Patient::findOrFail($patientId);

        $qrCodeUrl = route('dashboard.doctor.patients.prescriptions.qr', [
            'patient' => $patient->id,
            'prescription' => $prescription->id,
        ]);

        $qrCode = QrCode::size(150)->generate($qrCodeUrl);

        // Optionally return the QR code as a response or save it
        return response($qrCode)->header('Content-Type', 'image/svg+xml');
    }
}
