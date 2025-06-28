@extends('layouts.main')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main content -->
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-[#1D5E86] mb-6">Settings</h2>

        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex space-x-6" id="tabs">
                <li><a href="#account" class="tab-link text-gray-600 hover:text-[#1D5E86] font-semibold">Account Info</a></li>
                <li><a href="#clinic" class="tab-link text-gray-600 hover:text-[#1D5E86] font-semibold">Clinic Info</a></li>
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
                        <label class="block text-sm font-medium text-gray-700">Specialty</label>
                        <input type="text" name="specialty" value="{{ Auth::user()->specialty ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>
                </div>
            </form>
        </div>

        <!-- Clinic Info -->
        <div id="clinic" class="tab-content hidden">
            <form method="POST" action="{{ route('dashboard.doctor.settings.update') }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Clinic Address</label>
                        <input type="text" name="clinic_address" value="{{ $settings->clinic_address ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" name="phone" value="{{ $settings->phone ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Working Hours</label>
                        <input type="text" name="working_hours" value="{{ $settings->working_hours ?? '' }}" class="mt-1 block w-full rounded-md border border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Accepting New Patients</label>
                        <select name="accepting_new" class="mt-1 block w-full rounded-md border border-gray-300">
                            <option value="1" {{ $settings->accepting_new ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$settings->accepting_new ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <div class="text-right mt-6">
                    <button type="submit" class="bg-[#1D5E86] text-white px-6 py-2 rounded-md">Save Clinic Info</button>
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

<!-- Simple JS to handle tabs -->
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

        // Show first tab by default
        if (tabs.length > 0) {
            tabs[0].click();
        }
    });
</script>
@endsection
