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

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-[#1d5e86]">All Prescriptions</h1>
            <input type="text" placeholder="Search prescriptions..." class="px-4 py-2 border rounded-lg w-80">
        </div>

        <!-- Prescription List -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            @if($prescriptions->isEmpty())
                <p class="text-gray-500">No prescriptions found.</p>
            @else
                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-600 border-b">
                            <th class="pb-3">Doctor</th>
                            <th class="pb-3">Patient</th>
                            <th class="pb-3">Medications</th>
                            <th class="pb-3">Date</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($prescriptions as $prescription)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">
                                {{ $prescription->doctor->name ?? 'Unknown Doctor' }}<br>
                                <span class="text-sm text-gray-500">{{ $prescription->doctor->specialty ?? 'Specialty Unknown' }}</span>
                            </td>
                            <td class="py-3">{{ $prescription->patient->name ?? 'Unknown Patient' }}</td>
                            <td class="py-3">
                                @foreach($prescription->items as $item)
                                    {{ $item->medication->name ?? 'Unknown Medication' }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="py-3">{{ $prescription->created_at->format('d/m/Y') }}</td>
                            <td class="py-3">
                                <span class="font-semibold {{ $prescription->status === 'Completed' ? 'text-green-600' : 'text-orange-500' }}">
                                    {{ $prescription->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
</div>
@endsection
