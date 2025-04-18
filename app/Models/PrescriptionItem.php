<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $fillable = ['prescription_id', 'medicine_name', 'dosage', 'duration_days'];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
