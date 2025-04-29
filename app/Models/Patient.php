<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'name',
        'age',
        'medical_history',
        'doctor_id',
        'blood_group',
        'phone',
        'address',
        'condition',
        'condition_status',
        'allergies',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function notes()
    {
        return $this->hasMany(PatientNote::class);
    }
}
