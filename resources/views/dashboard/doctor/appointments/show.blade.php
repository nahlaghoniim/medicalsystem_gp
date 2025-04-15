@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Appointment Details</h2>
    
    <table class="table">
        <tr>
            <th>Patient</th>
            <td>{{ $appointment->patient->name }}</td>
        </tr>
        <tr>
            <th>Appointment Date</th>
            <td>{{ $appointment->appointment_date->format('d M Y, H:i') }}</td>
        </tr>
        <tr>
            <th>Notes</th>
            <td>{{ $appointment->notes ? $appointment->notes : 'No notes available' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($appointment->status) }}</td>
        </tr>
    </table>
    
    <a href="{{ route('doctor.appointments.index') }}" class="btn btn-secondary">Back to Appointments</a>
</div>
@endsection
