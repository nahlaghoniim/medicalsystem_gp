@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Payments</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Appointment</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->patient->name }}</td>
                    <td>{{ $payment->appointment->id }}</td>
                    <td>${{ number_format($payment->amount, 2) }}</td>
                    <td>{{ ucfirst($payment->method) }}</td>
                    <td>{{ ucfirst($payment->status) }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('doctor.payments.show', $payment->id) }}" class="btn btn-sm btn-primary">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No payments recorded yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
