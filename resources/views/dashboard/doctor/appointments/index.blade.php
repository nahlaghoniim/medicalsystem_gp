@extends('layouts.main')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-bold text-[#1D5E86] mb-6">Appointments for Dr. {{ Auth::user()->name }}</h1>

        <!-- Filter Summary -->
        @if(request('search') || request('status') || request('sort'))
            <div class="mb-4 text-sm text-gray-600">
                <strong>Filtered by:</strong>
                {{ request('search') ? 'Name: ' . request('search') . ' | ' : '' }}
                {{ request('status') ? 'Status: ' . request('status') . ' | ' : '' }}
                {{ request('sort') ? 'Sorted by: ' . ucfirst(request('sort')) : 'Date' }}
            </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
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

            <button type="submit" class="col-span-1 md:col-span-3 bg-[#1D5E86] text-white px-4 py-2 rounded hover:bg-[#154766]">
                Apply Filters
            </button>
        </form>

        <!-- Appointments Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Patient</th>
                        <th class="px-6 py-3">Appointment Date</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Payment</th>
                        <th class="px-6 py-3">Actions</th>
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
                            <td class="px-6 py-4" id="payment-cell-{{ $appointment->id }}">
                                @if($appointment->payment && $appointment->payment->status === 'paid')
                                    <span class="text-green-600 font-semibold">Paid</span>
                                @else
                                    <span class="text-red-500 font-semibold">Unpaid</span>
                                    <button type="button"
                                            onclick="markAsPaid({{ $appointment->id }})"
                                            class="ml-2 text-blue-500 hover:underline text-sm">
                                        Pay
                                    </button>
                                @endif
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
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $appointments->withQueryString()->links() }}
        </div>

        <!-- Add Appointment Button -->
        <div class="mt-4">
            <a href="{{ route('dashboard.doctor.appointments.create') }}" class="inline-block bg-[#1D5E86] text-white px-4 py-2 rounded hover:bg-[#154766]">
                + Add Appointment
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function markAsPaid(appointmentId) {
        if (!confirm('Confirm payment for this appointment?')) return;

fetch("{{ route('dashboard.doctor.appointments.markPaid', ':id') }}".replace(':id', appointmentId), ...)
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Request failed');
            return response.json();
        })
        .then(data => {
            if (data.status === 'paid') {
                document.getElementById(`payment-cell-${appointmentId}`).innerHTML =
                    '<span class="text-green-600 font-semibold">Paid</span>';
            }
        })
        .catch(error => {
            alert('Payment failed: ' + error.message);
        });
    }
</script>
@endsection
