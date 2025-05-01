@extends('layouts.main')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Create Appointment</h1>

    <form method="POST" action="{{ route('dashboard.doctor.appointments.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Patient</label>
            <select name="patient_id" class="w-full p-2 border rounded">
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Appointment Date</label>
            <input type="datetime-local" name="appointment_date" class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Status</label>
            <select name="status" class="w-full p-2 border rounded">
                <option value="Scheduled">Scheduled</option>
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Notes (optional)</label>
            <textarea name="notes" class="w-full p-2 border rounded"></textarea>
        </div>

        <button type="submit" class="bg-[#3B82F6] text-white px-4 py-2 rounded hover:bg-[#2563EB]">Save Appointment</button>
    </form>
</div>
@endsection
