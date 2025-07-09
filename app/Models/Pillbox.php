<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pillbox extends Model
{
    protected $fillable = [
        'patient_id', 'name', 'slots', 'timezone', 'device_uid'
    ];

    public function schedules()
    {
        return $this->hasMany(PillboxSchedule::class);
    }

    public function logs()
    {
        return $this->hasMany(PillboxLog::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
