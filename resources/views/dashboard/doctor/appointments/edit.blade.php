@extends('layouts.main')

@section('content')
<div class="container">
    <h2>Edit Appointment</h2>
    
    <form action="{{ route('dashboard.doctor.appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" id="patient_id" class="form-control" required>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                        {{ $patient->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" 
                value="{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d\TH:i') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $appointment->notes }}</textarea>
        </div>
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Appointment</button>
    </form>
</div>
@endsection
