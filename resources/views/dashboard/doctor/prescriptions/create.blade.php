@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold text-primary mb-6">Create Prescription</h1>

    <form action="{{ route('dashboard.doctor.prescriptions.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="patient_id" class="block text-gray-700 font-semibold mb-2">Patient ID</label>
            <input type="text" name="patient_id" id="patient_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" required>
        </div>

        <div>
            <label for="medications" class="block text-gray-700 font-semibold mb-2">Medications</label>
            <textarea name="medications" id="medications" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" placeholder="e.g., Paracetamol 500mg - Twice a day for 5 days" required></textarea>
        </div>

        <div>
            <label for="notes" class="block text-gray-700 font-semibold mb-2">Doctor Notes</label>
            <textarea name="notes" id="notes" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary focus:border-primary" placeholder="Optional notes..."></textarea>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-primary hover:bg-blue-800 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition">
                Submit Prescription
            </button>
        </div>
    </form>
</div>
@endsection
