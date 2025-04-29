@extends('layouts.main')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-semibold text-center mb-6">Patient Registration</h1>
        <p class="text-center text-gray-600 mb-8 text-sm">Enter the patient's credentials to connect them to the system.</p>

        <form action="{{ route('dashboard.doctor.patients.store') }}" method="POST">
            @csrf

            <!-- Patient Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Patient Name</label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Age -->
            <div class="mb-4">
                <label for="age" class="block text-sm font-medium text-gray-700 mb-2">Age</label>
                <input type="number" name="age" id="age" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Medical History -->
            <div class="mb-6">
                <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-2">Medical History</label>
                <textarea name="medical_history" id="medical_history" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Blood Group -->
            <div class="mb-4">
                <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-2">Blood Group</label>
                <input type="text" name="blood_group" id="blood_group" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                <input type="text" name="phone" id="phone" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea name="address" id="address" rows="2" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <!-- Condition -->
            <div class="mb-4">
                <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                <input type="text" name="condition" id="condition" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Condition Status -->
            <div class="mb-4">
                <label for="condition_status" class="block text-sm font-medium text-gray-700 mb-2">Condition Status</label>
                <select name="condition_status" id="condition_status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="">Select Status</option>
                    <option value="Stable">Stable</option>
                    <option value="Emergency">Emergency</option>
                    <option value="Urgent">Urgent</option>
                    <option value="Recovering">Recovering</option>
                    <option value="Critical">Critical</option>
                </select>
            </div>
            

            <!-- Allergies -->
            <div class="mb-6">
                <label for="allergies" class="block text-sm font-medium text-gray-700 mb-2">Allergies</label>
                <input type="text" name="allergies" id="allergies" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition">
                Register Patient
            </button>
        </form>
    </div>
</div>
@endsection
