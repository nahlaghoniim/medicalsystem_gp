@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-semibold mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
            d="M12 4v16m8-8H4"/></svg>
        Clinic Settings
    </h2>

    <form method="POST" action="{{ route('dashboard.doctor.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Clinic Address</label>
                <input type="text" name="clinic_address" value="{{ old('clinic_address', $settings->clinic_address ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $settings->phone ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Working Hours</label>
                <input type="text" name="working_hours" placeholder="e.g., 9 AM - 5 PM"
                    value="{{ old('working_hours', $settings->working_hours ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Accepting New Patients</label>
                <select name="accepting_new" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="1" {{ old('accepting_new', $settings->accepting_new ?? 1) ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('accepting_new', $settings->accepting_new ?? 1) ? '' : 'selected' }}>No</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Notification Preferences</label>
            <div class="mt-2 space-x-4">
                <label><input type="checkbox" name="notifications[]" value="email"
                    {{ isset($settings) && in_array('email', $settings->notifications ?? []) ? 'checked' : '' }}> Email</label>

                <label><input type="checkbox" name="notifications[]" value="sms"
                    {{ isset($settings) && in_array('sms', $settings->notifications ?? []) ? 'checked' : '' }}> SMS</label>
            </div>
        </div>

        <div class="text-right">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700">Save Settings</button>
        </div>
    </form>
</div>
@endsection
