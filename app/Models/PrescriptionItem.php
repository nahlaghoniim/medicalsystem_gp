<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'medicine_id', // Assuming you have a medicine_id column that references a medication
        'dosage',
        'duration_days',
    ];

    // Define the relationship to the Medication model
    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medicine_id');
    }
    

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
