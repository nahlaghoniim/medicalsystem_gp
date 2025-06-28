@extends('layouts.main')

@section('content')
<div class="flex justify-center bg-gray-100 min-h-screen py-10">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-[#1D5E86] mb-6 flex items-center gap-2">
            <i class="fas fa-calendar-plus text-[#1D5E86]"></i> Create Appointment
        </h2>

        <form method="POST" action="{{ route('dashboard.doctor.appointments.store') }}" class="space-y-6">
            @csrf

            <!-- Patient -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Select Patient</label>
                <select name="patient_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Appointment Date</label>
                <input type="datetime-local" name="appointment_date"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]" required>
            </div>

            <!-- Status -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                <select name="status"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]">
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>

            <!-- Notes -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">Notes (optional)</label>
                <textarea name="notes" rows="4"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-[#1D5E86] focus:border-[#1D5E86]"></textarea>
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button type="submit"
                        class="bg-[#1D5E86] text-white font-semibold px-6 py-2 rounded-lg hover:bg-[#164d6b] transition">
                    <i class="fas fa-save mr-2"></i> Save Appointment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
