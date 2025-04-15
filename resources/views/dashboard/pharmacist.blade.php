{{-- resources/views/dashboard/pharmacist.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Welcome, {{ Auth::user()->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">Pending Prescriptions</h2>
            <p>See prescriptions waiting to be filled.</p>
            <a href="#" class="text-green-600 hover:underline mt-2 inline-block">View Now</a>
        </div>

        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-2">Dispense History</h2>
            <p>Review your past dispensed prescriptions.</p>
            <a href="#" class="text-green-600 hover:underline mt-2 inline-block">View History</a>
        </div>
    </div>
</div>
@endsection
