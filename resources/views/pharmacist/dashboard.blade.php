@extends('layouts.pharmacist') {{-- Use the new clean layout --}}

@section('content')
<div class="min-h-screen flex bg-gray-100 font-sans text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r flex flex-col justify-between">
        <div>
            <div class="p-6 flex items-center space-x-2">
                <img src="/images/wessal.png" class="h-8 w-8" alt="Logo">
                <span style="color: #1d5e86;" class="font-bold text-xl">WESSAL</span>
            </div>
            <nav class="mt-4 space-y-1">
                <a href="#" style="color: #1d5e86; background-color: #d6e7f1;" class="flex items-center px-6 py-3 font-medium rounded-r-full">
                    <i class="fas fa-prescription-bottle-alt mr-3"></i> Prescriptions
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                    <i class="fas fa-user-injured mr-3"></i> Patient Records
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                    <i class="fas fa-envelope mr-3"></i> Messages
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>
            </nav>
        </div>

        <!-- Bottom profile -->
        <div class="p-4 border-t">
            <div class="flex items-center space-x-3 mb-4">
                <img src="/images/profile.jpg" class="w-10 h-10 rounded-full" alt="User">
                <div class="text-sm font-semibold">
                    {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-500 capitalize">
                    {{ auth()->user()->role }}
                </div>
            </div>
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white border-b p-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <button class="text-gray-600 text-xl"><i class="fas fa-bars"></i></button>
                <input type="text" placeholder="Search" class="bg-gray-100 border border-gray-300 rounded px-4 py-2 w-80 focus:outline-none focus:ring">
            </div>
            <div class="flex items-center space-x-4">
                <a href="#"><i class="fas fa-bell text-gray-500 text-xl"></i></a>
                <a href="#"><i class="fas fa-question-circle text-gray-500 text-xl"></i></a>
                <img src="/images/profile.jpg" class="w-10 h-10 rounded-full" alt="User">
            </div>
        </header>

        <!-- Main card -->
        <main class="flex-1 flex items-center justify-center p-10">
            <div class="bg-white p-10 rounded-xl shadow-md w-full max-w-xl text-center">
                <h2 class="text-xl font-semibold mb-2">Access Patient Prescriptions Easily</h2>
                <p class="text-gray-600 mb-6">Choose how you want to view a patient’s details — scan their card or enter ID manually.</p>
                <img src="/images/pd.png" alt="Medical Kit" class="w-48 mx-auto mb-6" />
                <div class="flex justify-center gap-4">
                    <a href="{{ route('dashboard.pharmacist.patient.search.form') }}" class="font-semibold px-4 py-2 rounded transition border border-blue-800 text-blue-800 hover:bg-blue-50">
                        + Enter Patient Credentials
                    </a>

                   <a href="{{ route('dashboard.pharmacist.scan') }}" class="text-white font-semibold px-4 py-2 rounded transition" style="background-color: #1d5e86;">
    <i class="fas fa-id-card mr-2"></i> Scan Patient Card
</a>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- FontAwesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
