<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PillboxLog extends Model
{
    protected $fillable = [
        'pillbox_id', 'slot_number', 'action', 'timestamp', 'synced_by_device'
    ];

    public function pillbox()
    {
        return $this->belongsTo(Pillbox::class);
    }
}
