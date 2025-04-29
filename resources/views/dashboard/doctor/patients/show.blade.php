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
                    <div>
                        <strong>Condition:</strong> {{ $patient->condition ?? 'N/A' }}
                    </div>
                    <div>
                        <strong>Allergies:</strong> {{ $patient->allergies ?? 'None' }}
                    </div>
                    <div>
                        <strong>Condition Status:</strong> {{ $patient->condition_status ?? 'N/A' }}
                    </div>
                    <div>
                        <strong>Address:</strong> {{ $patient->address ?? 'N/A' }}
                    </div>
                    <div>
                        <strong>Phone:</strong> {{ $patient->phone ?? 'N/A' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Prescriptions Section -->
<div class="bg-white rounded-xl shadow-md p-6 mb-8">
    <h3 class="text-xl font-bold mb-4">Prescriptions</h3>
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
@endsection

