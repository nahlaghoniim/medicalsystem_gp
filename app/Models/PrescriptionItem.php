<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class PrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'medicine_name',      // Now allows manual entry of medicine name
        'dosage',
        'duration_days',
    ];

    /**
     * Get the prescription that owns this item.
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
    public function medication()
{
    return $this->belongsTo(Medication::class, 'medicine_id');
}
}
