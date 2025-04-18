<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionHistory extends Model
{
    protected $fillable = ['prescription_id', 'changed_by', 'change_type'];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
