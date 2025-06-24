@extends('layouts.pharmacist')

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

            <!-- Dashboard -->
            <a href="{{ route('dashboard.pharmacist.index') }}"
                class="flex items-center px-6 py-3 {{ Request::is('pharmacist/dashboard') ? 'bg-[#d6e7f1] text-[#1d5e86] font-bold' : 'text-gray-700' }} hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                <i class="fas fa-home mr-3"></i> Dashboard
            </a>

            <!-- Prescriptions -->
            <a href="{{ route('dashboard.pharmacist.prescriptions.all') }}"
                class="flex items-center px-6 py-3 {{ Request::is('pharmacist/dashboard/prescriptions') ? 'bg-[#d6e7f1] text-[#1d5e86] font-bold' : 'text-gray-700' }} hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                <i class="fas fa-prescription-bottle-alt mr-3"></i> Prescriptions
            </a>

            <!-- Patient Records -->
            <a href="{{ route('dashboard.pharmacist.patients.index') }}"
                class="flex items-center px-6 py-3 {{ Request::is('pharmacist/dashboard/patients') ? 'bg-[#d6e7f1] text-[#1d5e86] font-bold' : 'text-gray-700' }} hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                <i class="fas fa-user-injured mr-3"></i> Patient Records
            </a>

            <!-- Messages -->
            <a href="{{ route('dashboard.pharmacist.messages.index') }}"
                class="flex items-center px-6 py-3 {{ Request::is('pharmacist/dashboard/messages') ? 'bg-[#d6e7f1] text-[#1d5e86] font-bold' : 'text-gray-700' }} hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                <i class="fas fa-envelope mr-3"></i> Messages
            </a>

            <!-- Settings -->
            <a href="{{ route('dashboard.pharmacist.settings') }}"
                class="flex items-center px-6 py-3 {{ Request::is('pharmacist/dashboard/settings') ? 'bg-[#d6e7f1] text-[#1d5e86] font-bold' : 'text-gray-700' }} hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
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
            <!-- Logout Button -->
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-gray-700 hover:text-red-500 transition text-xl" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
    </button>
</form>

        </div>
    </aside>

    <!-- Settings Card -->
    <div class="flex-1 p-8">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Pharmacist Settings</h2>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl shadow-lg max-w-4xl mx-auto">
            <form action="{{ route('dashboard.pharmacist.settings.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <!-- Pharmacy Name -->
                <div>
                    <label for="clinic_address" class="block text-gray-700 font-semibold mb-2">Pharmacy Name</label>
                    <input type="text" name="clinic_address" id="clinic_address" value="{{ old('clinic_address', $setting->clinic_address ?? '') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Pharmacy Name">
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $setting->phone ?? '') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Phone Number">
                </div>

                <!-- Notification Preferences -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Notification Preferences</label>
                    <select name="notifications[]" multiple class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="email" {{ isset($setting) && str_contains($setting->notifications, 'email') ? 'selected' : '' }}>Email</option>
                        <option value="sms" {{ isset($setting) && str_contains($setting->notifications, 'sms') ? 'selected' : '' }}>SMS</option>
                    </select>
                    <small class="text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple options.</small>
                </div>

                <!-- Working Hours -->
                <div>
                    <label for="working_hours" class="block text-gray-700 font-semibold mb-2">Working Hours</label>
                    <input type="text" name="working_hours" id="working_hours" value="{{ old('working_hours', $setting->working_hours ?? '') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex: 9:00 AM - 9:00 PM">
                </div>

                <!-- Low Stock Alert -->
                <div>
                    <label for="low_stock_alert" class="block text-gray-700 font-semibold mb-2">Low Stock Alert (Quantity)</label>
                    <input type="number" name="low_stock_alert" id="low_stock_alert" value="{{ old('low_stock_alert', $setting->low_stock_alert ?? '') }}" class="w-full p-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ex: 5">
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl transition text-lg">Save Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
