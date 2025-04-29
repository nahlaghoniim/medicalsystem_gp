<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
}


