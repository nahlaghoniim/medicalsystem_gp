<?php

namespace App\Models;
use Illuminate\Support\Str;

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
        'image' ,
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_conditions','emergency_token',
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
    public function payments()
{
    return $this->hasMany(Payment::class);
}
protected static function booted()
{
    static::creating(function ($patient) {
        if (empty($patient->emergency_token)) {
            $patient->emergency_token = Str::uuid()->toString();
        }
    });
}
}
