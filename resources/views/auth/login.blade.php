@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- Logo Top Left -->

<div class="absolute top-6 left-6 flex items-center space-x-2 z-50">
    <img src="{{ asset('images/wessal.png') }}" alt="WESAL Logo" class="h-10">
    <span class="text-2xl font-bold" style="color: #1d5e86;">WESAL</span>
</div>

    <!-- Left side image -->
    <div class="w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('images/background.jpg') }}');">
        <!-- Background only -->
    </div>

    <!-- Right side form -->
    <div class="w-1/2 flex items-center justify-center">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-2">Welcome Back!</h2>

            @if(session('selected_role'))
                <div class="mb-4 text-sm text-gray-600">
                    Logging in as: 
                    <span class="font-semibold capitalize text-indigo-600">
                        {{ session('selected_role') }}
                    </span>
                </div>
            @endif

            <!-- Social buttons -->
            <div class="flex gap-4 mb-4">
                <a href="{{ route('auth.facebook') }}" class="flex-1 flex items-center justify-center gap-2 border border-blue-600 text-blue-600 py-2 rounded">
                    <img src="{{ asset('images/facebook.png') }}" alt="Facebook" class="w-5 h-5">
                    Facebook
                </a>
                <a href="{{ route('auth.google') }}" class="flex-1 flex items-center justify-center gap-2 border border-red-500 text-red-500 py-2 rounded">
                    <img src="{{ asset('images/google.png') }}" alt="Google" class="w-5 h-5">
                    Google
                </a>
            </div>

            <div class="mb-4 text-center text-gray-400">or</div>

            <!-- Login form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Optional: hidden field to re-submit role -->
                @if(session('selected_role'))
                    <input type="hidden" name="role" value="{{ session('selected_role') }}">
                @endif

                <div class="mb-4">
                    <input type="email" name="email" class="w-full p-3 border rounded" placeholder="Email" required autofocus>
                </div>

                <div class="mb-6">
                    <input type="password" name="password" class="w-full p-3 border rounded" placeholder="Password" required>
                </div>

                <button type="submit" class="w-full text-white py-3 rounded" style="background-color: #1d5e86;">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Don't have an account? Sign up</a>
            </div>
        </div>
    </div>
</div>
@endsection
