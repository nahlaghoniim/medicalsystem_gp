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
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-[#1D5E86] mb-6">Settings</h2>

        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex space-x-6" id="tabs">
                <li><a href="#account" class="tab-link text-gray-600 hover:text-[#1D5E86] font-semibold">Account Info</a></li>
                <li><a href="#pharmacy" class="tab-link text-gray-600 hover:text-[#1D5E86] font-semibold">Pharmacy Info</a></li>
                <li><a href="#notifications" class="tab-link text-gray-600 hover:text-[#1D5E86] font-semibold">Notifications</a></li>
                <li><a href="#security" class="tab-link text-gray-600 hover:text-[#1D5E86] font-semibold">Security</a></li>
            </ul>
        </div>

        <!-- Account Info -->
        <div id="account" class="tab-content">
            <form method="POST" action="#">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}" class="mt-1 block w-full rounded-md border border-gray-300" readonly>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">License ID</label>
                        <input type="text" name="license_id" value="{{ Auth::user()->license_id ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>
                </div>
            </form>
        </div>

        <!-- Pharmacy Info -->
        <div id="pharmacy" class="tab-content hidden">
            <form method="POST" action="{{ route('dashboard.pharmacist.settings.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pharmacy Address</label>
                        <input type="text" name="pharmacy_address" value="{{ $settings->pharmacy_address ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ $settings->phone ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Working Hours</label>
                        <input type="text" name="working_hours" value="{{ $settings->working_hours ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>
                </div>
                <div class="text-right mt-6">
                    <button type="submit" class="bg-[#1D5E86] text-white px-6 py-2 rounded-md">Save Pharmacy Info</button>
                </div>
            </form>
        </div>

        <!-- Notifications -->
        <div id="notifications" class="tab-content hidden">
            <form method="POST" action="#">
                @csrf
                <label class="block text-sm font-medium text-gray-700 mb-4">Notification Methods</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="notifications[]" value="email" checked>
                        Email
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="notifications[]" value="sms">
                        SMS
                    </label>
                </div>
            </form>
        </div>

        <!-- Security -->
        <div id="security" class="tab-content hidden">
            <form method="POST" action="#">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>
                </div>
                <div class="text-right mt-6">
                    <button type="submit" class="bg-[#1D5E86] text-white px-6 py-2 rounded-md">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS Tabs -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tab-link');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                contents.forEach(c => c.classList.add('hidden'));
                document.querySelector(tab.getAttribute('href')).classList.remove('hidden');

                tabs.forEach(t => t.classList.remove('text-[#1D5E86]'));
                tab.classList.add('text-[#1D5E86]');
            });
        });

        if (tabs.length > 0) {
            tabs[0].click();
        }
    });
</script>
@endsection
