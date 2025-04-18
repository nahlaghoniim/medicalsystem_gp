@extends('layouts.main')

@section('content')
<div class="container">
    <h1 class="mb-4">All Prescriptions</h1>

    <a href="{{ route('dashboard.doctor.prescriptions.create') }}" class="btn btn-primary mb-3">+ Add New Prescription</a>

    @if($prescriptions->isEmpty())
        <p>No prescriptions found.</p>
    @else
        <div class="list-group">
            @foreach($prescriptions as $prescription)
                <a href="{{ route('dashboard.doctor.prescriptions.show', $prescription->id) }}" class="list-group-item list-group-item-action">
                    <strong>Patient:</strong> {{ $prescription->patient_name ?? 'Unknown' }} |
                    <strong>Date:</strong> {{ $prescription->created_at->format('d M Y') }}
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
