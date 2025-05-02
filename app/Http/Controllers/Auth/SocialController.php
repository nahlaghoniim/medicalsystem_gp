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
    $googleUser = \Laravel\Socialite\Facades\Socialite::driver('google')->stateless()->user();

    $user = \App\Models\User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'password' => bcrypt('password'),
        ]
    );

    Auth::login($user);

    return redirect()->route('home'); // or wherever you want
}

public function redirectToFacebook()
{
    return Socialite::driver('facebook')->redirect();
}

public function handleFacebookCallback()
{
    $facebookUser = Socialite::driver('facebook')->user();

    // Find or create user
    $user = User::firstOrCreate([
        'email' => $facebookUser->getEmail()
    ], [
        'name' => $facebookUser->getName(),
        'provider_id' => $facebookUser->getId(),
        'provider' => 'facebook',
        // optional: fill password, role, etc.
    ]);

    Auth::login($user);
    return redirect()->route('dashboard.user', ['id' => $user->id]);
}


  
}
