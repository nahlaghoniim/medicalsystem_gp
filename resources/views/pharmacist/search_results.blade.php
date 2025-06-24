@extends('layouts.main')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center" style="color: #1D5E86;">Search Patient</h2>
        <form action="{{ route('pharmacist.patient.search.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="patient_id" class="block mb-2 font-medium">Patient ID</label>
                <input type="text" id="patient_id" name="patient_id" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="patient_name" class="block mb-2 font-medium">Patient Name</label>
                <input type="text" id="patient_name" name="patient_name" required class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-800 text-white py-2 rounded-lg hover:bg-blue-900">Search</button>
        </form>
    </div>
</div>
@endsection
