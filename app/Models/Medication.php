<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'name', 'generic_name', 'manufacturer', 'description', 'dosage_form', 'strength'
    ];
    
}