@extends('layouts.main')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">
    <h1 class="text-2xl font-semibold text-primary mb-4">Payment Details</h1>

    <div class="grid grid-cols-2 gap-4">
        <div><strong>Payment ID:</strong> {{ $payment->id }}</div>
        <div><strong>Patient:</strong> {{ $payment->patient->name }}</div>
        <div><strong>Appointment ID:</strong> {{ $payment->appointment->id }}</div>
        <div><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</div>
        <div><strong>Method:</strong> {{ ucfirst($payment->method) }}</div>
        <div><strong>Status:</strong> {{ ucfirst($payment->status) }}</div>
        <div><strong>Date:</strong> {{ $payment->created_at->format('Y-m-d') }}</div>
    </div>

    <div class="mt-6">
        <a href="{{ route('dashboard.doctor.payments.index') }}" class="text-blue-600 hover:underline">← Back to Payments</a>
    </div>
</div>
@endsection
