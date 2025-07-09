<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ray;
use Illuminate\Support\Facades\Storage;

class RayController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('rays', 'public');

        // Simulated AI diagnosis
        $diagnosisOptions = [
            'Mild Pneumonia',
            'Fracture Detected',
            'No Abnormality Detected',
            'Signs of Infection'
        ];
        $diagnosis = $diagnosisOptions[array_rand($diagnosisOptions)];

        Ray::create([
            'patient_id' => $patientId,
            'image' => $path,
            'ai_diagnosis' => $diagnosis,
        ]);

        return redirect()->back()->with('success', 'Ray uploaded and diagnosed!');
    }

    public function destroy($patientId, Ray $ray)
    {
        // Delete the image from storage
        if ($ray->image && Storage::disk('public')->exists($ray->image)) {
            Storage::disk('public')->delete($ray->image);
        }

        // Delete the ray record
        $ray->delete();

        return back()->with('success', 'Ray deleted successfully.');
    }
}
