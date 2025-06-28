@extends('layouts.main')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#1D5E86]">Payments</h2>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-700 rounded-lg shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Payments Table -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Patient</th>
                        <th class="px-6 py-3">Appointment</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Method</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Created At</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $payment->id }}</td>
                            <td class="px-6 py-4">{{ $payment->patient->name }}</td>
                            <td class="px-6 py-4">#{{ $payment->appointment->id }}</td>
                            <td class="px-6 py-4">${{ number_format($payment->amount, 2) }}</td>
                            <td class="px-6 py-4">{{ ucfirst($payment->method) }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-3 py-1 rounded-full
                                    {{ $payment->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $payment->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('dashboard.doctor.payments.show', $payment->id) }}"
                                   class="text-blue-600 hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center px-6 py-4 text-gray-500">
                                No payments recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
