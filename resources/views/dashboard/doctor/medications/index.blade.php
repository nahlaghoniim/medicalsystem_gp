@extends('layouts.main')

@section('content')
<div class="flex min-h-screen bg-gray-100">

    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-[#1D5E86] mb-6">💊 Available Medications</h2>

        <!-- Search -->
        <form action="{{ route('dashboard.doctor.medications.index') }}" method="GET" class="mb-6 max-w-lg">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, generic, company..."
                    class="w-full py-2 px-4 pl-10 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#1D5E86] focus:outline-none"
                />
                <span class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </form>

        <!-- Table -->
        <div class="bg-white shadow-md rounded-xl overflow-x-auto">
            <table class="min-w-full table-auto text-sm text-left border-collapse">
                <thead class="bg-[#1D5E86] text-white uppercase">
                    <tr>
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Drug Name</th>
                        <th class="py-3 px-6">Generic Name</th>
                        <th class="py-3 px-6">Company</th>
                        <th class="py-3 px-6">Dosage Form</th>
                        <th class="py-3 px-6">Strength</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-800 bg-white">
                    @forelse ($medications as $index => $med)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-6">{{ $index + 1 }}</td>
                            <td class="py-3 px-6 font-semibold text-[#1D5E86]">{{ $med->name }}</td>
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

            <!-- Pagination -->
            <div class="p-6">
                {{ $medications->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
