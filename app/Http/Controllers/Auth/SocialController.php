<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            ['name' => $googleUser->getName(), 'password' => bcrypt('password')] // dummy password
        );

        Auth::login($user);
        return redirect()->route('home'); // redirect where you want
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $fbUser = Socialite::driver('facebook')->user();
        $user = User::firstOrCreate(
            ['email' => $fbUser->getEmail()],
            ['name' => $fbUser->getName(), 'password' => bcrypt('password')]
        );

        Auth::login($user);
        return redirect()->route('home');
    }
}
