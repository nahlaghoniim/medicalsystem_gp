@extends('layouts.main')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h2 class="text-xl font-bold mb-4">Add Prescription for {{ $patient->name }}</h2>

    <form method="POST" action="{{ route('dashboard.doctor.patients.prescriptions.store', ['patient' => $patient->id]) }}">
        @csrf

        <div id="medication-fields">
            <div class="mb-4 border p-4 rounded">
                <label class="block font-semibold mb-1">Medicine Name</label>
                <input type="text" name="medications[0][medicine_name]" class="w-full border rounded p-2 mb-2" required>

                <label class="block font-semibold mb-1">Dosage (e.g., 1 tablet twice daily)</label>
                <input type="text" name="medications[0][dosage]" class="w-full border rounded p-2 mb-2" required>

                <label class="block font-semibold mb-1">Duration (days)</label>
                <input type="number" name="medications[0][duration_days]" class="w-full border rounded p-2" required>
            </div>
        </div>

        <button type="button" id="add-more" class="bg-gray-200 px-4 py-2 rounded mb-4">+ Add Another</button>

        <button type="submit" class="bg-primary text-white px-6 py-2 rounded">Save Prescription</button>
    </form>
</div>

<script>
    let count = 1;
    document.getElementById('add-more').addEventListener('click', function () {
        const container = document.createElement('div');
        container.className = 'mb-4 border p-4 rounded';
        container.innerHTML = `
            <label class="block font-semibold mb-1">Medicine Name</label>
            <input type="text" name="medications[${count}][medicine_name]" class="w-full border rounded p-2 mb-2" required>

            <label class="block font-semibold mb-1">Dosage (e.g., 1 tablet twice daily)</label>
            <input type="text" name="medications[${count}][dosage]" class="w-full border rounded p-2 mb-2" required>

            <label class="block font-semibold mb-1">Duration (days)</label>
            <input type="number" name="medications[${count}][duration_days]" class="w-full border rounded p-2" required>
        `;
        document.getElementById('medication-fields').appendChild(container);
        count++;
    });
</script>
@endsection