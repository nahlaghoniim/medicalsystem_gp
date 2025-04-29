@extends('layouts.main')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">All Prescriptions</h1>
        <a href="{{ route('dashboard.doctor.prescriptions.create') }}" class="btn btn-sm btn-primary">
            + Add New Prescription
        </a>
    </div>

    @if($prescriptions->isEmpty())
        <div class="alert alert-info">
            No prescriptions found.
        </div>
    @else
        <div class="row">
            @foreach($prescriptions as $prescription)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-1">{{ $prescription->patient->name ?? 'Unknown' }}</h5>
                            <small class="text-muted d-block mb-3">
                                <strong>Date:</strong> {{ $prescription->created_at->format('d M Y') }}
                            </small>
                            <a href="{{ route('dashboard.doctor.prescriptions.show', $prescription->id) }}" class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
