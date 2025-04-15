@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Appointments</h2>
    <a href="{{ route('dashboard.doctor.appointments.create') }}" class="btn btn-primary">Create New Appointment</a>
    
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Patient</th>
                <th>Appointment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient->name }}</td>
                    <td>{{ $appointment->appointment_date->format('d M Y, H:i') }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                    <td>
                        <a href="{{ route('dashboard.doctor.appointments.edit', $appointment->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('dashboard.doctor.appointments.show', $appointment->id) }}" class="btn btn-info">Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
