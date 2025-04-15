@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Add New Patient</h1>

    <form action="{{ route('dashboard.doctor.patients.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-lg font-semibold">Patient Name</label>
            <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="age" class="block text-lg font-semibold">Age</label>
            <input type="number" name="age" id="age" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="medical_history" class="block text-lg font-semibold">Medical History</label>
            <textarea name="medical_history" id="medical_history" class="w-full px-4 py-2 border rounded"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Patient</button>
    </form>
</div>
@endsection
