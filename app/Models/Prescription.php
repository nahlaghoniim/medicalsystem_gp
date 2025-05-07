<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;




class Prescription extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'issued_at', 'is_active'];

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function history()
    {
        return $this->hasMany(PrescriptionHistory::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function prescriptionItems()
{
    return $this->hasMany(PrescriptionItem::class);
}
public function generatePdf($prescriptionId)
{
    $prescription = Prescription::with('patient', 'items')->findOrFail($prescriptionId);

    // Generate QR code for the prescription URL

    // Pass prescription data and QR code to the view
    $pdf = Pdf::loadView('prescriptions.pdf', compact('prescription', 'qrCode'));
    $qrCode = QrCode::size(150)->generate(route('dashboard.doctor.prescriptions.qr', $prescription->id));

    // Return the generated PDF for download
    return $pdf->download('prescription-' . $prescription->id . '.pdf');
}

public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id'); // or whatever your foreign key is
}




}


