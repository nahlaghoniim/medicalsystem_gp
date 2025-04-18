@extends('layouts.main')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Welcome, Dr. {{ Auth::user()->name }}</h2>

    <div class="row g-4">
        {{-- My Patients --}}
        <div class="col-md-4">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">👨‍⚕️ My Patients</h5>
                    <p class="card-text text-muted">View and manage your patient list.</p>
                    <a href="{{ route('patients.index') }}" class="btn btn-outline-primary">View Patients</a>
                </div>
            </div>
        </div>

        {{-- Appointments --}}
        <div class="col-md-4">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">📅 Appointments</h5>
                    <p class="card-text text-muted">Manage your upcoming appointments.</p>
                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">Check Schedule</a>
                </div>
            </div>
        </div>

        {{-- Prescriptions --}}
        <div class="col-md-4">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">💊 Prescriptions</h5>
                    <p class="card-text text-muted">Create or edit prescriptions for your patients.</p>
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-success">Manage Prescriptions</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Optional: Summary stats or patient table here --}}
    <div class="mt-5">
        <h4>Patient Details</h4>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Medical History</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->age }}</td>
                            <td>{{ $patient->history ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
