@extends('layouts.main')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl font-bold text-center text-[#1D5E86] mb-2">Edit Patient</h1>
        <p class="text-center text-gray-500 mb-6 text-sm">Update the patient's information below.</p>

        <form action="{{ route('dashboard.doctor.patients.update', $patient->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <!-- Patient Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Patient Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]" required>
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                    <input type="number" name="age" id="age" value="{{ old('age', $patient->age) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]" required>
                </div>

                <!-- Medical History -->
                <div>
                    <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-1">Medical History</label>
                    <textarea name="medical_history" id="medical_history" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">{{ old('medical_history', $patient->medical_history) }}</textarea>
                </div>

                <!-- Blood Group -->
                <div>
                    <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                    <input type="text" name="blood_group" id="blood_group" value="{{ old('blood_group', $patient->blood_group) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="2" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">{{ old('address', $patient->address) }}</textarea>
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                    <input type="text" name="condition" id="condition" value="{{ old('condition', $patient->condition) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                </div>

                <!-- Condition Status -->
                <div>
                    <label for="condition_status" class="block text-sm font-medium text-gray-700 mb-1">Condition Status</label>
                    <select name="condition_status" id="condition_status" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                        <option value="">Select Status</option>
                        <option value="Stable" {{ old('condition_status', $patient->condition_status) == 'Stable' ? 'selected' : '' }}>Stable</option>
                        <option value="Emergency" {{ old('condition_status', $patient->condition_status) == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                        <option value="Urgent" {{ old('condition_status', $patient->condition_status) == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="Recovering" {{ old('condition_status', $patient->condition_status) == 'Recovering' ? 'selected' : '' }}>Recovering</option>
                        <option value="Critical" {{ old('condition_status', $patient->condition_status) == 'Critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <!-- Allergies -->
                <div>
                    <label for="allergies" class="block text-sm font-medium text-gray-700 mb-1">Allergies</label>
                    <input type="text" name="allergies" id="allergies" value="{{ old('allergies', $patient->allergies) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full bg-[#1D5E86] hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Update Patient
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
