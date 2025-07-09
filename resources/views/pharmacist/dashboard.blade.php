
@extends('layouts.pharmacist')

@section('content')
<div class="min-h-screen flex bg-gray-100 font-sans text-gray-800">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r flex flex-col justify-between">
        <div>
            <div class="p-6 flex items-center space-x-2">
                <img src="/images/wessal.png" class="h-8 w-8" alt="Logo">
                <span style="color: #1d5e86;" class="font-bold text-xl">WESAL</span>
            </div>
            <nav class="mt-4 space-y-1">
<a href="{{ route('dashboard.pharmacist.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard') ? 'active' : '' }}">
   <i class="fas fa-home mr-3"></i> Dashboard
</a>

<a href="{{ route('dashboard.pharmacist.prescriptions.all') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/prescriptions') ? 'active' : '' }}">
   <i class="fas fa-prescription-bottle-alt mr-3"></i> Prescriptions
</a>

<a href="{{ route('dashboard.pharmacist.patients.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/patients') ? 'active' : '' }}">
   <i class="fas fa-user-injured mr-3"></i> Patient Records
</a>

<a href="{{ route('dashboard.pharmacist.messages.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/messages') ? 'active' : '' }}">
   <i class="fas fa-envelope mr-3"></i> Messages
</a>

<a href="{{ route('dashboard.pharmacist.settings') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/settings') ? 'active' : '' }}">
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
    <button type="submit" class="text-gray-700 hover:text-red-500 transition text-xl" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
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
            <div class="bg-white p-14 rounded-2xl shadow-lg w-full max-w-4xl text-center">
                <h2 class="text-2xl font-bold mb-4">Access Patient Prescriptions Easily</h2>
                <p class="text-gray-600 mb-8 text-lg">Choose how you want to view a patient’s details — scan their card or enter ID manually.</p>
                <img src="/images/pd.png" alt="Medical Kit" class="w-64 mx-auto mb-8" />
                <div class="flex justify-center gap-6">
                    <a href="{{ route('dashboard.pharmacist.patient.search.form') }}" class="font-semibold px-6 py-3 rounded-lg transition border border-blue-800 text-blue-800 hover:bg-blue-50">
                        + Enter Patient Credentials
                    </a>

                    <a href="{{ route('dashboard.pharmacist.scan') }}" class="text-white font-semibold px-6 py-3 rounded-lg transition" style="background-color: #1d5e86;">
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