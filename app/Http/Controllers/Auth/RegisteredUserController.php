<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle initial registration and store data in session.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Store registration data in session temporarily
        Session::put('registration_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // store plain password for now
        ]);

        return redirect()->route('role.select');
    }

    /**
     * Show the role selection view.
     */
    public function selectRole(): View
    {
        return view('auth.select-role');
    }

    /**
     * Finalize registration after role is selected.
     */
    public function saveRole(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:doctor,pharmacist'],
        ]);

        $data = Session::get('registration_data');

        if (!$data) {
            return redirect()->route('register')->withErrors('Please register first.');
        }

        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $request->role,
        ]);

        Session::forget('registration_data'); // clean up session
        Auth::login($user); // log the user in

        // Redirect to role-based dashboard
        return $request->role === 'doctor'
            ? redirect()->route('dashboard.doctor.index')
            : redirect()->route('dashboard.pharmacist');
    }
}
