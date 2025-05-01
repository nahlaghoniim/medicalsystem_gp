<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['clinic_address', 'phone', 'notifications'];

    protected $casts = [
        'notifications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

