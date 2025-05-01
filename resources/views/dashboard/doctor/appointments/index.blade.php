@extends('layouts.main')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6">Appointments for Dr. {{ Auth::user()->name }}</h1>

    <!-- Filter Summary -->
    @if(request('search') || request('status') || request('sort'))
        <div class="mb-2 text-sm text-gray-600">
            <strong>Filtered by:</strong>
            {{ request('search') ? 'Name: ' . request('search') . ' | ' : '' }}
            {{ request('status') ? 'Status: ' . request('status') . ' | ' : '' }}
            {{ request('sort') ? 'Sorted by: ' . ucfirst(request('sort')) : 'Date' }}
        </div>
    @endif

    <!-- Filter Form -->
    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by patient name" class="p-2 border rounded">

        <select name="status" class="p-2 border rounded">
            <option value="">All Statuses</option>
            <option value="Scheduled" {{ request('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <select name="sort" class="p-2 border rounded">
            <option value="">Sort by Date</option>
            <option value="patient" {{ request('sort') == 'patient' ? 'selected' : '' }}>Sort by Patient</option>
        </select>

        <button type="submit" class="col-span-1 md:col-span-3 bg-[#3B82F6] text-white px-4 py-2 rounded hover:bg-[#2563EB]">
            Apply Filters
        </button>
        
    </form>

    <!-- Appointments Table -->
    <div class="mt-4">
        <table class="min-w-full bg-white rounded-xl overflow-hidden shadow">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left">Patient</th>
                    <th class="px-6 py-3 text-left">Appointment Date</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $appointment->patient->name }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y \a\t h:i A') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded-full
                                {{ $appointment->status === 'Completed' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $appointment->status === 'Cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $appointment->status === 'Scheduled' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-3 text-sm">
                            <a href="{{ route('dashboard.doctor.appointments.edit', $appointment) }}" class="text-yellow-600 hover:underline">Edit</a>

                            @if ($appointment->status === 'Scheduled')
                                <form action="{{ route('dashboard.doctor.appointments.markCompleted', $appointment) }}" method="POST" onsubmit="return confirm('Mark this appointment as completed?')">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Complete</button>
                                </form>
                            @endif

                            @if ($appointment->status !== 'Cancelled')
                                <form action="{{ route('dashboard.doctor.appointments.cancel', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-6 py-4 text-gray-500">No appointments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $appointments->withQueryString()->links() }}
    </div>
    <a href="{{ route('dashboard.doctor.appointments.create') }}" class="inline-block bg-[#3B82F6] text-white px-4 py-2 rounded hover:bg-[#2563EB] mb-4">
        + Add Appointment
    </a>
    
</div>
@endsection
