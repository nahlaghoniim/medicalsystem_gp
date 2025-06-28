@extends('layouts.main')

@section('content')
<div class="flex bg-gray-50 min-h-screen font-sans text-gray-800">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-[#1D5E86]">All Prescriptions</h1>

            <form method="GET" class="flex flex-col md:flex-row items-start md:items-center gap-2"
                onsubmit="
                    event.preventDefault(); 
                    const patientId = this.querySelector('[name=patient_id]').value;
                    if (patientId) {
                        window.location.href = '{{ url('doctor/dashboard/patients') }}/' + patientId + '/prescriptions/create';
                    }
                ">
                <select name="patient_id" class="rounded-md border-gray-300 shadow-sm text-sm py-2 px-3" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-4 rounded shadow">
                    + Add Prescription
                </button>
            </form>
        </div>

        @if($prescriptions->isEmpty())
            <div class="bg-blue-100 text-blue-800 px-6 py-4 rounded-md shadow-sm text-center">
                No prescriptions found.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($prescriptions as $prescription)
                    <div class="bg-white shadow rounded-xl p-5 flex flex-col justify-between h-full">
                        <div>
                            <h2 class="text-lg font-semibold text-[#1D5E86] mb-1">
                                {{ $prescription->patient->name ?? 'Unknown' }}
                            </h2>
                            <p class="text-sm text-gray-500 mb-3">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $prescription->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('dashboard.doctor.prescriptions.show', $prescription->id) }}"
                                class="inline-block bg-transparent border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition rounded-full px-4 py-1 text-sm font-medium">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</div>
@endsection
