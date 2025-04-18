@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Prescription</h1>

    <form action="{{ route('prescriptions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient ID</label>
            <input type="text" name="patient_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="medications" class="form-label">Medications</label>
            <textarea name="medications" class="form-control" rows="5" placeholder="e.g., Paracetamol 500mg - Twice a day for 5 days" required></textarea>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Doctor Notes</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Optional notes..."></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Prescription</button>
    </form>
</div>
@endsection
