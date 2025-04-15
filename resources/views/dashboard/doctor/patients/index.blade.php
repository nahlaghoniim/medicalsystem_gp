@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Patient List</h1>

    <a href="{{ route('dashboard.doctor.patients.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Patient</a>

    <div class="mt-6">
        <table class="min-w-full bg-white rounded-xl overflow-hidden shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Age</th>
                    <th class="px-6 py-3 text-left">Medical History</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $patient->name }}</td>
                        <td class="px-6 py-4">{{ $patient->age }}</td>
                        <td class="px-6 py-4">{{ $patient->medical_history }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('dashboard.doctor.patients.show', $patient) }}" class="text-blue-500 hover:underline">View</a> |
                            <a href="{{ route('dashboard.doctor.patients.edit', $patient) }}" class="text-yellow-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
