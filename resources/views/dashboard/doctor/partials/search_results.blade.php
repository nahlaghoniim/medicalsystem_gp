@forelse($medications as $med)
    <li class="p-3 hover:bg-gray-100 cursor-pointer" onclick="addMedicationToPrescription({{ $med->toJson() }})">
        <strong>{{ $med->name }}</strong> – {{ $med->form ?? '' }}
    </li>
@empty
    <li class="p-3 text-gray-500">No results found</li>
@endforelse
