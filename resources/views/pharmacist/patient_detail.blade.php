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
             <a href="{{ route('dashboard.pharmacist.prescriptions.all') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
    <i class="fas fa-prescription-bottle-alt mr-3"></i> Prescriptions
</a>
             <a href="{{ route('dashboard.pharmacist.patients.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                    <i class="fas fa-user-injured mr-3"></i> Patient Records
                </a>
             <a href="{{ route('dashboard.pharmacist.messages.index') }}" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                    <i class="fas fa-envelope mr-3"></i> Messages
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-700 hover:bg-[#d6e7f1] hover:text-[#1d5e86] transition">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>
            </nav>
        </div>

        <!-- Bottom profile -->
        <div class="p-4 border-t">
            <div class="flex items-center space-x-3">
                <img src="/images/profile.jpg" class="w-10 h-10 rounded-full" alt="User">
               <div class="text-sm font-semibold">
    {{ auth()->user()->name }}
</div>
<div class="text-xs text-gray-500 capitalize">
    {{ auth()->user()->role }}
</div>

            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <button><i class="fa fa-bars text-2xl text-gray-600"></i></button>
                <input type="text" placeholder="Search" class="border px-4 py-2 rounded-lg w-80">
            </div>
            <div class="flex items-center gap-6">
                <i class="fa fa-bell text-2xl text-gray-600"></i>
                <img src="/images/profile.jpg" class="w-10 h-10 rounded-full" alt="User">
            </div>
        </div>

        <!-- Patient Info -->
        <div class="bg-white p-6 rounded-xl shadow-md flex items-center gap-6 mb-8">
            <div class="bg-green-200 text-3xl font-bold text-center text-gray-800 h-20 w-20 rounded-full flex items-center justify-center">
                {{ strtoupper(substr($patient->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold">{{ $patient->name }}</h2>
                <p class="text-gray-500">ID: #{{ $patient->id }}</p>
                <div class="mt-2 text-gray-600">
                    <p><strong>Patient Condition:</strong> {{ $patient->condition ?? 'Not Available' }}</p>
                    <p><strong>Allergies:</strong> {{ $patient->allergies ?? 'None' }}</p>
                    <p><strong>Current Medications:</strong> 
                        @if(!empty($patient->current_medications))
                            {{ $patient->current_medications }}
                        @else
                            No current medications
                        @endif
                    </p>
                </div>
            </div>
            <div class="ml-auto text-right text-gray-700">
                <p><strong>Blood group:</strong> <span style="color: #1D5E86;" class="font-semibold">{{ $patient->blood_group ?? 'Unknown' }}</span></p>
                <p><strong>Age:</strong> {{ $patient->age ?? 'Unknown' }} Years</p>
            </div>
        </div>

        <!-- Prescriptions List -->
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h3 class="text-xl font-semibold mb-4">Prescriptions</h3>

            @if($patient->prescriptions->isEmpty())
                <p class="text-gray-500">No prescriptions found for this patient.</p>
            @else
                <div class="space-y-4">
                    @foreach($patient->prescriptions as $prescription)
                        <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('images/doctor1.jpg') }}" alt="Doctor" class="h-12 w-12 rounded-full object-cover">
                                <div>
                                    <h4 class="font-semibold">{{ $prescription->doctor->name ?? 'Unknown Doctor' }}</h4>
                                    <p class="text-gray-500 text-sm">{{ $prescription->doctor->specialty ?? 'Specialty Unknown' }}</p>
                                </div>
                            </div>
                            <p class="text-gray-600">{{ $prescription->created_at->format('d/m/Y') }}</p>

                            <p class="text-gray-600">
                                @foreach($prescription->items as $item)
                                    {{ $item->medication->name ?? 'Unknown Medication' }}@if(!$loop->last), @endif
                                @endforeach
                            </p>

                            <span class="{{ $prescription->status == 'Active' ? 'text-green-600' : 'text-orange-500' }} font-semibold">{{ $prescription->status }}</span>

                            <i class="fa fa-comment-dots text-gray-500"></i>

<form action="{{ route('dashboard.pharmacist.pharmacist.prescription.complete', $prescription->id) }}" method="POST">
    @csrf
    <button type="submit" class="px-4 py-2 rounded-lg flex items-center gap-2 text-white" style="background-color: #1D5E86;">
        Complete <i class="fa fa-chevron-down"></i>
    </button>
</form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
