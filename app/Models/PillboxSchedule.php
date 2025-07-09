<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PillboxSchedule extends Model
{
   protected $fillable = [
    'pillbox_id', 'medication_id', 'slot_number',
    'dosage', 'time', 'days_of_week', 'active',
    'start_date', 'end_date'
];


    protected $casts = [
        'days_of_week' => 'array',
    ];

    public function pillbox()
    {
        return $this->belongsTo(Pillbox::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
