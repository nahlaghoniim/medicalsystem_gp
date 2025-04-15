@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Patient Details: {{ $patient->name }}</h1>

    <div class="mb-4">
        <strong>Age:</strong> {{ $patient->age }}
    </div>

    <div class="mb-4">
        <strong>Medical History:</strong> {{ $patient->medical_history }}
    </div>

    <a href="{{ route('dashboard.doctor.patients.edit', $patient) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit Patient</a>
</div>
@endsection
