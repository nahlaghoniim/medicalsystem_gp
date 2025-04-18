@extends('layouts.main')

@section('content')
<div class="container mx-auto p-6">

    <!-- Welcome message -->
    <h1 class="text-3xl font-bold mb-6">Welcome, Dr. {{ $doctorName }}</h1>

    <!-- Dashboard Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Your dashboard content -->
    </div>

    <!-- Appointments List -->
    <div class="mt-6">
        <table class="min-w-full bg-white rounded-xl overflow-hidden shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">Patient</th>
                    <th class="px-6 py-3 text-left">Appointment Date</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td class="px-6 py-4">{{ $appointment->patient->name }}</td>
                        <td class="px-6 py-4">{{ $appointment->appointment_date }}</td>
                        <td class="px-6 py-4">{{ $appointment->status }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('dashboard.doctor.appointments.edit', $appointment) }}" class="text-yellow-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
