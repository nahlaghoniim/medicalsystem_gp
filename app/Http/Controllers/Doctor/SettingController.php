<?php

namespace App\Http\Controllers\Dashboard\Doctor;
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = auth()->user()->setting; // assumes hasOne relationship
        return view('dashboard.doctor.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'clinic_address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'notifications' => 'nullable|array',
        ]);

        $user = auth()->user();

        // If the setting already exists, update it; otherwise, create it
        $settings = Setting::updateOrCreate(
            ['user_id' => $user->id], // condition to check if settings exist
            $request->only(['clinic_address', 'phone', 'notifications'])
        );

        return back()->with('success', 'Settings updated successfully.');
    }
}
