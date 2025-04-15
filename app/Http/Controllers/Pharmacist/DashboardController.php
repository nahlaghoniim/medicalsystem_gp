<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pharmacist = Auth::user();
        return view('dashboard.pharmacist', compact('pharmacist'));
    }
}
