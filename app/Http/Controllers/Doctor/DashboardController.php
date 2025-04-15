<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user();
        $patients = $doctor->patients; // بدل ما نجيبهم بـ where

        return view('dashboard.doctor.doctor', compact('doctor', 'patients'));
    }
}