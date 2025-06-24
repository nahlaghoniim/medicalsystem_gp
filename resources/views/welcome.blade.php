@extends('layouts.app')

@section('content')
<div class="bg-white text-gray-800">

    <!-- Hero Section with Gradient Background -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-20">
        <div class="container mx-auto text-center px-6">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Smart Healthcare System</h1>
            <p class="text-lg md:text-xl mb-6">Empowering doctors and pharmacists with technology for smarter, safer, and more connected patient care.</p>
            @guest
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Get Started
                </a>
                <a href="{{ route('login') }}" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Login
                </a>
            </div>
        @endguest
        @auth
        @php $user = Auth::user(); @endphp
    
        <div class="flex justify-center gap-4">
            @if ($user->role === 'doctor')
                <a href="{{ route('dashboard.doctor.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Go to Doctor Dashboard
                </a>
            @elseif ($user->role === 'pharmacist')
<a href="{{ route('dashboard.pharmacist.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
    Go to Pharmacist Dashboard
</a>
                    Go to Pharmacist Dashboard
                </a>
            @endif
    
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-transparent border border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Logout
                </button>
            </form>
        </div>
    @endauth
    

        </div>
    </section>

    <!-- Key Features Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-12 text-gray-800">Key Features</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg transform transition hover:scale-105 duration-300">
                    <i class="fas fa-user-md text-4xl mb-3 text-blue-600"></i>
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">Doctor & Pharmacist Dashboard</h3>
                    <p class="text-gray-700">Login securely and manage patients, prescriptions, and real-time data effortlessly.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg transform transition hover:scale-105 duration-300">
                    <i class="fas fa-cogs text-4xl mb-3 text-blue-600"></i>
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">AI Tools & Smart Devices</h3>
                    <p class="text-gray-700">Track medication schedules with smart pill boxes and hydration with smart water bottles.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg transform transition hover:scale-105 duration-300">
                    <i class="fas fa-heartbeat text-4xl mb-3 text-blue-600"></i>
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">Emergency NFC Access</h3>
                    <p class="text-gray-700">Critical patient data instantly available via NFC in emergency situations.</p>
                </div>
                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg transform transition hover:scale-105 duration-300">
                    <i class="fas fa-id-card text-4xl mb-3 text-blue-600"></i>
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">ID Verification</h3>
                    <p class="text-gray-700">Secure and verified patient identity through government ID linking.</p>
                </div>
                <!-- Feature 5 -->
                <div class="bg-white p-6 rounded-lg shadow-lg transform transition hover:scale-105 duration-300">
                    <i class="fas fa-calendar-alt text-4xl mb-3 text-blue-600"></i>
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">Calendar Integration</h3>
                    <p class="text-gray-700">Schedule and manage appointments with a built-in calendar for doctors.</p>
                </div>
                <!-- Feature 6 -->
                <div class="bg-white p-6 rounded-lg shadow-lg transform transition hover:scale-105 duration-300">
                    <i class="fas fa-barcode text-4xl mb-3 text-blue-600"></i>
                    <h3 class="text-xl font-semibold mb-3 text-blue-600">Prescription Barcode Scanner</h3>
                    <p class="text-gray-700">Pharmacists can scan prescriptions for quick verification and medicine dispensing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section with Divider -->
    <section class="py-16 bg-blue-50 text-center relative">
        <div class="absolute inset-0 bg-blue-800 opacity-50"></div>
        <div class="container mx-auto text-center px-6 relative z-10">
            <h2 class="text-3xl font-semibold text-gray-800">Join the Future of Healthcare</h2>
            <p class="text-lg text-gray-600 mb-6">Sign up now and experience an intelligent and connected medical system built for modern needs.</p>
            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
        </div>
    </section>
</div>

@endsection

