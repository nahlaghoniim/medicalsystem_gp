@extends('layouts.pharmacist')

@section('content')
<div class="flex min-h-screen bg-gray-100">
   <!-- Sidebar -->
<aside class="w-64 bg-white border-r flex flex-col justify-between">
    <div>
        <div class="p-6 flex items-center space-x-2">
            <img src="/images/wessal.png" class="h-8 w-8" alt="Logo">
            <span style="color: #1d5e86;" class="font-bold text-xl">WESSAL</span>
        </div>
        <nav class="mt-4 space-y-1">

            <!-- Dashboard -->
           <a href="{{ route('dashboard.pharmacist.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard') ? 'active' : '' }}">
   <i class="fas fa-home mr-3"></i> Dashboard
</a>

<a href="{{ route('dashboard.pharmacist.prescriptions.all') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/prescriptions') ? 'active' : '' }}">
   <i class="fas fa-prescription-bottle-alt mr-3"></i> Prescriptions
</a>

<a href="{{ route('dashboard.pharmacist.patients.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/patients') ? 'active' : '' }}">
   <i class="fas fa-user-injured mr-3"></i> Patient Records
</a>

<a href="{{ route('dashboard.pharmacist.messages.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/messages') ? 'active' : '' }}">
   <i class="fas fa-envelope mr-3"></i> Messages
</a>

<a href="{{ route('dashboard.pharmacist.settings') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/settings') ? 'active' : '' }}">
   <i class="fas fa-cog mr-3"></i> Settings
</a>

        </nav>
    </div>


        <!-- Bottom profile -->
        <div class="p-4 border-t">
            <div class="flex items-center space-x-3 mb-4">
                <img src="/images/profile.jpg" class="w-10 h-10 rounded-full" alt="User">
                <div class="text-sm font-semibold">
                    {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-500 capitalize">
                    {{ auth()->user()->role }}
                </div>
            </div>
            <!-- Logout Button -->
            <!-- Logout Button -->
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-gray-700 hover:text-red-500 transition text-xl" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
    </button>
</form>

        </div>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-700">Patient Records</h1>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold mb-4">All Patients</h2>

            @if($patients->isEmpty())
                <p class="text-gray-500">No patients found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-3 px-4 border">ID</th>
                                <th class="py-3 px-4 border">Name</th>
                                <th class="py-3 px-4 border">Age</th>
                                <th class="py-3 px-4 border">Blood Group</th>
                                <th class="py-3 px-4 border">Condition</th>
                                <th class="py-3 px-4 border">Allergies</th>
                                <th class="py-3 px-4 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                                <tr class="border-t">
                                    <td class="py-2 px-4">{{ $patient->id }}</td>
                                    <td class="py-2 px-4">{{ $patient->name }}</td>
                                    <td class="py-2 px-4">{{ $patient->age ?? 'Unknown' }}</td>
                                    <td class="py-2 px-4">{{ $patient->blood_group ?? 'Unknown' }}</td>
                                    <td class="py-2 px-4">{{ $patient->condition ?? 'N/A' }}</td>
                                    <td class="py-2 px-4">{{ $patient->allergies ?? 'None' }}</td>
                                    <td class="py-2 px-4">
                                        <a href="{{ route('dashboard.pharmacist.patients.view', $patient->id) }}" class="text-blue-600 hover:underline">View Prescriptions</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
