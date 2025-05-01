@extends('layouts.main') <!-- Or your layout file -->

@section('content')
<div class="container">
    <h2>Add New Payment</h2>

    <form action="{{ route('doctor.payments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="appointment_id">Appointment ID</label>
            <input type="number" name="appointment_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="patient_id">Patient ID</label>
            <input type="number" name="patient_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="amount">Amount</label>
            <input type="number" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="method">Method</label>
            <input type="text" name="method" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
                <option value="refunded">Refunded</option>
            </select>
        </div>

        <
