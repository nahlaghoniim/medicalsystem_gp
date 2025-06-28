@extends('layouts.main')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="bg-white shadow-lg rounded-2xl p-8 max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-[#1D5E86] mb-6">Edit Appointment</h2>

            <form action="{{ route('dashboard.doctor.appointments.update', $appointment->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Patient Select -->
                <div>
                    <label for="patient_id" class="block text-sm font-semibold text-gray-700 mb-1">Patient</label>
                    <select name="patient_id" id="patient_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Appointment Date -->
                <div>
                    <label for="appointment_date" class="block text-sm font-semibold text-gray-700 mb-1">Appointment Date</label>
                    <input type="datetime-local" id="appointment_date" name="appointment_date" required
                        value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Notes</label>
                    <textarea id="notes" name="notes" rows="4"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">{{ $appointment->notes }}</textarea>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                        <option value="Scheduled" {{ $appointment->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="text-right">
                    <button type="submit"
                        class="bg-[#1D5E86] hover:bg-[#154766] text-white px-6 py-2 rounded-lg shadow transition">
                        Update Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
