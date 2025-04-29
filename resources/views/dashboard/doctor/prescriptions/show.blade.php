@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">Prescription Details</h1>

    <div class="card">
        <div class="card-body">
            <h5><strong>Patient:</strong> {{ $prescription->patient->name ?? 'N/A' }}</h5>
            <p><strong>Date:</strong> {{ $prescription->created_at->format('d M Y') }}</p>
            <hr>
            <p><strong>Medications:</strong></p>
            <pre>{{ $prescription->medications }}</pre>
            <p><strong>Doctor Notes:</strong></p>
            <p>{{ $prescription->notes ?? 'No additional notes.' }}</p>
        </div>
    </div>
</div>
@endsection
