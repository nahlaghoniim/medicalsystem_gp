@extends('layouts.main')

@section('content')
<div class="flex bg-gray-50 min-h-screen font-sans text-gray-800">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8 space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Register New Patient</h1>
            <a href="{{ route('dashboard.doctor.patients.index') }}" class="text-sm text-blue-600 hover:underline">← Back to Patients</a>
        </div>

        <!-- Form Container -->
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-4xl mx-auto">
            <p class="text-gray-600 mb-6 text-sm">Fill in the patient's information to register them into the system.</p>

            <form action="{{ route('dashboard.doctor.patients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Grid Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                        <input type="file" name="image" id="image" class="w-full border border-gray-300 rounded-md px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="text-xs text-gray-400 mt-1">Optional - Upload a patient photo.</p>
                    </div>

                    <!-- Age -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age <span class="text-red-500">*</span></label>
                        <input type="number" name="age" id="age" required class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <label for="blood_group" class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label>
                        <input type="text" name="blood_group" id="blood_group" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" id="phone" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea name="address" id="address" rows="2" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Condition -->
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Medical Condition</label>
                        <input type="text" name="condition" id="condition" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Condition Status -->
                    <div>
                        <label for="condition_status" class="block text-sm font-medium text-gray-700 mb-1">Condition Status</label>
                        <select name="condition_status" id="condition_status" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Status</option>
                            <option value="Stable">Stable</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Recovering">Recovering</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>

                    <!-- Allergies -->
                    <div>
                        <label for="allergies" class="block text-sm font-medium text-gray-700 mb-1">Allergies</label>
                        <input type="text" name="allergies" id="allergies" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Medical History -->
                    <div class="md:col-span-2">
                        <label for="medical_history" class="block text-sm font-medium text-gray-700 mb-1">Medical History</label>
                        <textarea name="medical_history" id="medical_history" rows="3" class="w-full border border-gray-300 rounded-md shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                                   <a href="{{ route('dashboard.doctor.patients.create') }}"
   class="block w-full bg-[#1D5E86] hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md text-center transition">
   + Register Patient
</a>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
