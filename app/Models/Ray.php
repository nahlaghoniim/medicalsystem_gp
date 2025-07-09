<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ray extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'image',
        'ai_diagnosis',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
