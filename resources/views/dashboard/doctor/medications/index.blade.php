@extends('layouts.main')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Available Medications</h2>

    <div class="bg-white shadow-md rounded-xl overflow-hidden">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Drug Name</th>
                    <th class="py-3 px-6 text-left">Generic Name</th>
                    <th class="py-3 px-6 text-left">Company</th>
                    <th class="py-3 px-6 text-left">Dosage Form</th>
                    <th class="py-3 px-6 text-left">Strength</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                @forelse ($medications as $index => $med)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-6">{{ $index + 1 }}</td>
                        <td class="py-3 px-6 font-medium">{{ $med->name }}</td>
                        <td class="py-3 px-6">{{ $med->generic_name ?? '—' }}</td>
                        <td class="py-3 px-6">{{ $med->manufacturer ?? '—' }}</td>
                        <td class="py-3 px-6">{{ $med->dosage_form ?? '—' }}</td>
                        <td class="py-3 px-6">{{ $med->strength ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 px-6 text-center text-gray-500">No medications found.</td>
                    </tr>
                @endforelse
               
                
            </tbody>
        </table>
        <div class="mt-6">
            {{ $medications->links() }}
        </div>
    </div>
</div>
@endsection
