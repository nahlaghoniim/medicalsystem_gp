@extends('layouts.main')

@section('content')
<div class="flex bg-gray-50 min-h-screen text-gray-800">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h1 class="text-2xl font-bold text-[#1D5E86]">Prescription Details</h1>
            <a href="{{ route('dashboard.doctor.prescriptions.index') }}"
               class="text-sm text-gray-700 hover:text-blue-600 transition">
                ← Back to All Prescriptions
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700">Patient</h2>
                <p class="text-sm text-gray-600">{{ $prescription->patient->name ?? 'N/A' }}</p>
            </div>

            <div class="mb-6">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Date</h2>
                <p class="text-sm text-gray-700">{{ $prescription->created_at->format('d M Y') }}</p>
            </div>

            <hr class="my-6 border-gray-200">

            <div class="mb-6">
                <h2 class="text-lg font-semibold text-[#1D5E86]">Medications</h2>
                <pre class="bg-gray-100 text-gray-800 text-sm rounded-md p-4 whitespace-pre-wrap">
{{ $prescription->medications }}
                </pre>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-[#1D5E86]">Doctor Notes</h2>
                <p class="text-gray-700 text-sm mt-2">
                    {{ $prescription->notes ?? 'No additional notes.' }}
                </p>
            </div>
        </div>
    </main>
</div>
@endsection
