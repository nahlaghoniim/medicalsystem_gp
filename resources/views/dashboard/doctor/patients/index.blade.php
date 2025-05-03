@extends('layouts.main')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#1d5e86]">Patients</h1>
        <a href="{{ route('dashboard.doctor.patients.create') }}" class="bg-[#1d5e86] hover:bg-blue-800 text-white px-6 py-2 rounded-lg shadow transition">
            + Add Patient
        </a>
    </div>

    <!-- Patients Table -->
    <div class="bg-white rounded-2xl shadow-md overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3">Patient Name</th>
                    <th class="px-6 py-3">Age</th>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Diagnosis</th>
                    <th class="px-6 py-3">Treatment Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($patients as $patient)
                    <tr>
                        <!-- Patient Name -->
                        <td class="px-6 py-4 font-medium text-gray-900 flex items-center space-x-3">
                            @if($patient->image)
                                <img src="{{ asset('storage/' . $patient->image) }}" alt="Patient" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($patient->name) }}" alt="Avatar" class="w-10 h-10 rounded-full">
                            @endif
                            <span>{{ $patient->name }}</span>
                        </td>

                        <!-- Age -->
                        <td class="px-6 py-4">
                            {{ $patient->age ? $patient->age . ' Years' : 'Unknown' }}
                        </td>

                        <!-- Date -->
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($patient->created_at)->format('m/d/Y') }}
                        </td>

                        <!-- Diagnosis -->
                        <td class="px-6 py-4">
                            {{ $patient->condition ?? 'Unknown' }}
                        </td>

                        <!-- Treatment Status -->
                        <td class="px-6 py-4">
                            @php
                                $treatmentStatus = $patient->condition_status ?? 'Unknown';
                                $badgeClasses = 'bg-gray-100 text-gray-600';

                                if ($treatmentStatus == 'Stable') {
                                    $badgeClasses = 'bg-green-100 text-green-600';
                                } elseif ($treatmentStatus == 'Urgent') {
                                    $badgeClasses = 'bg-yellow-100 text-yellow-600';
                                } elseif ($treatmentStatus == 'Emergency') {
                                    $badgeClasses = 'bg-red-100 text-red-600';
                                } elseif ($treatmentStatus == 'Critical') {
                                    $badgeClasses = 'bg-red-200 text-red-700';
                                } elseif ($treatmentStatus == 'Recovering') {
                                    $badgeClasses = 'bg-blue-100 text-blue-600';
                                }
                            @endphp
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClasses }}">
                                {{ $treatmentStatus }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('dashboard.doctor.patients.show', $patient) }}" class="text-blue-500 hover:underline text-sm">View</a>
                            <a href="{{ route('dashboard.doctor.patients.edit', $patient) }}" class="text-yellow-500 hover:underline text-sm">Edit</a>
                            <form action="{{ route('dashboard.doctor.patients.destroy', $patient) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-500 hover:underline text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                            No patients found. <a href="{{ route('dashboard.doctor.patients.create') }}" class="text-blue-500 underline">Add a new patient</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="p-6">
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection
