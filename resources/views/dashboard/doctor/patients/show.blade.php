@extends('layouts.main')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <!-- Patient Info Card -->
        <div class="flex flex-col md:flex-row bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="md:w-1/3 bg-primary text-white p-6 flex flex-col justify-center items-center">
                <img class="w-24 h-24 rounded-full mb-4" src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}&background=0D8ABC&color=fff" alt="Patient photo">
                <h2 class="text-2xl font-bold">{{ $patient->name }}</h2>
                <p class="text-sm mt-1">ID: #{{ $patient->id }}</p>
                <p class="text-sm">{{ $patient->disease ?? 'No Diagnosis' }}</p>
                <p class="mt-2">Blood group: <strong>{{ $patient->blood_group ?? 'N/A' }}</strong></p>
                <p>Age: <strong>{{ $patient->age }} Years</strong></p>
            </div>

            <div class="md:w-2/3 p-6 space-y-4">
                <h3 class="text-lg font-semibold mb-2">Patient Summary</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
                    <div><strong>Condition:</strong> {{ $patient->condition ?? 'N/A' }}</div>
                    <div><strong>Allergies:</strong> {{ $patient->allergies ?? 'None' }}</div>
                    <div><strong>Condition Status:</strong> {{ $patient->condition_status ?? 'N/A' }}</div>
                    <div><strong>Address:</strong> {{ $patient->address ?? 'N/A' }}</div>
                    <div><strong>Phone:</strong> {{ $patient->phone ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Add Prescription + Search Icon -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                </svg>
                Prescriptions
            </h3>
            <button onclick="document.getElementById('addPrescriptionModal').classList.remove('hidden')" 
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                + Add Prescription
            </button>
        </div>
<!-- Prescriptions Section -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold">Prescriptions</h3>
        <a href="{{ route('dashboard.doctor.patients.prescriptions.create', ['patient' => $patient->id]) }}"
            class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Add Prescription
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-2 px-4 text-left">Drug</th>
                    <th class="py-2 px-4 text-left">Dosage & Frequency</th>
                    <th class="py-2 px-4 text-left">Intake</th>
                    <th class="py-2 px-4 text-left">Duration (days)</th>
                    <th class="py-2 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patient->prescriptions as $prescription)
                    @foreach($prescription->items as $index => $item)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item->medicine_name }}</td>
                            <td class="py-2 px-4">{{ $item->dosage }}</td>
                            <td class="py-2 px-4">{{ Str::before($item->dosage, ' ') }}</td>
                            <td class="py-2 px-4">{{ $item->duration_days }}</td>

                            @if ($index === 0)
                                <td class="py-2 px-4" rowspan="{{ $prescription->items->count() }}">
                                    <a href="{{ route('dashboard.doctor.prescriptions.edit', $prescription->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td class="py-2 px-4" colspan="5">No prescriptions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($patient->prescriptions->isNotEmpty())
    @php
        $latestPrescription = $patient->prescriptions->last();
    @endphp
    <div class="flex gap-4 mt-6">
        <a href="{{ route('dashboard.doctor.patients.prescriptions.pdf', $patient->id) }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Download PDF
        </a>

        <a href="{{ route('dashboard.doctor.patients.prescriptions.qr', ['patient' => $patient->id, 'prescription' => $latestPrescription->id]) }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h4v4H3V3zm14 0h4v4h-4V3zM3 17h4v4H3v-4zm14 0h4v4h-4v-4z" />
            </svg>
            View QR Code
        </a>
    </div>
@endif
</div>


        <!-- Notes Section -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-xl font-bold mb-4">Add Note</h3>
            <form action="{{ route('dashboard.doctor.patients.notes.store', $patient->id) }}" method="POST">
                @csrf
                <textarea name="note" class="w-full border rounded-lg p-4 mb-4" rows="4" placeholder="Type your note here..."></textarea>
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Medication Search Modal -->
<div id="addPrescriptionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6 relative">
        <!-- Close button -->
        <button onclick="document.getElementById('addPrescriptionModal').classList.add('hidden')" 
                class="absolute top-2 right-4 text-gray-600 text-xl">&times;</button>
        
        <h2 class="text-lg font-semibold mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1111 3a7.5 7.5 0 015.65 13.65z" />
            </svg>
            Search & Add Medication
        </h2>
        
        <input type="text" id="medicationSearch" onkeyup="searchMedication()" placeholder="Search medications..." 
               class="w-full border rounded-lg p-3 mb-4">

        <ul id="medicationResults" class="max-h-60 overflow-y-auto border rounded-lg divide-y">
            <!-- JS will populate results -->
        </ul>
    </div>
</div>

<script>
    function searchMedication() {
        const query = document.getElementById('medicationSearch').value;
        const resultsList = document.getElementById('medicationResults');
        if (query.length < 2) {
            resultsList.innerHTML = '';
            return;
        }

        fetch(`/medications/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                resultsList.innerHTML = '';
                if (data.length === 0) {
                    resultsList.innerHTML = '<li class="p-3 text-gray-500">No results found</li>';
                    return;
                }

                data.forEach(med => {
                    const li = document.createElement('li');
                    li.className = 'p-3 hover:bg-gray-100 cursor-pointer';
                    li.innerHTML = `<strong>${med.name}</strong> – ${med.form || ''}`;
                    li.onclick = () => addMedicationToPrescription(med);
                    resultsList.appendChild(li);
                });
            });
    }

    function addMedicationToPrescription(med) {
        const patientId = {{ $patient->id }};
        window.location.href = `/dashboard/doctor/prescriptions/create/${patientId}?medication_id=${med.id}`;
        document.getElementById('addPrescriptionModal').classList.add('hidden');
    }
</script>
@endsection
