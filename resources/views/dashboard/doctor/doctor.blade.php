 @extends('layouts.main')

@section('content')
<div class="container mx-auto p-6">

    <!-- Welcome message -->
    <h1 class="text-3xl font-bold mb-6">Welcome, Dr. {{ Auth::user()->name }}</h1>

    <!-- Overview Cards for Doctor -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- My Patients Card -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">My Patients</h2>
            <p>View and manage your patient list.</p>
            <a href="{{ route('dashboard.doctor.patients.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">View Patients</a>
        </div>

        <!-- Appointments Card -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">Appointments</h2>
            <p>Manage your upcoming appointments.</p>
            <a href="{{ route('dashboard.doctor.appointments.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">Check Schedule</a>
        </div>

        <!-- Prescriptions Card -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">Prescriptions</h2>
            <p>Create or edit prescriptions for your patients.</p>
            <a href="{{ route('dashboard.doctor.prescriptions.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">Manage Prescriptions</a>
        </div>
    </div>

    <!-- Patients List (Grid View) -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-4">My Patients</h2>
        @if($patients->isEmpty())
            <p class="text-center text-gray-500">No patients found.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($patients as $patient)
                    <div class="bg-white p-4 rounded-xl shadow">
                        <h3 class="text-xl font-semibold">{{ $patient->name }}</h3>
                        <p><strong>Age:</strong> {{ $patient->age }}</p>
                        <p><strong>Medical History:</strong> {{ $patient->medical_history }}</p>
                        <a href="{{ route('dashboard.doctor.patients.show', $patient) }}" class="text-blue-500 hover:underline mt-2 inline-block">View Details</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Patients List (Table View) -->
    <div class="mt-10">
        <h2 class="text-2xl font-bold mb-4">Patient Details</h2>
        <table class="min-w-full bg-white rounded-xl overflow-hidden shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Age</th>
                    <th class="px-6 py-3 text-left">Medical History</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                    <tr class="border-t">
                        <td class="px-6 py-4">{{ $patient->name }}</td>
                        <td class="px-6 py-4">{{ $patient->age }}</td>
                        <td class="px-6 py-4">{{ $patient->medical_history }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('dashboard.doctor.patients.edit', $patient) }}" class="text-yellow-500 hover:underline">Edit</a> |
                            <a href="{{ route('dashboard.doctor.patients.show', $patient) }}" class="text-blue-500 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection 
 


