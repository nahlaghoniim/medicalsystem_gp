@extends('layouts.main')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-semibold mb-4">Edit Prescription</h2>
    <hr class="my-6">

    {{-- List of Prescription Items --}}
    @foreach ($prescription->items as $item)
    <div class="mb-4 border p-4 rounded shadow bg-white" id="item-{{ $item->id }}">
        {{-- Update Form --}}
        <form class="update-item-form" data-id="{{ $item->id }}" 
              action="{{ route('dashboard.doctor.prescription-items.update', $item->id) }}" 
              method="POST">
            @csrf
            @method('PUT')
            <label class="block font-medium">Medicine Name</label>
            <input type="text" name="medicine_name" class="form-control mb-2 w-full" value="{{ $item->medicine_name }}">

            <label class="block font-medium">Dosage</label>
            <input type="text" name="dosage" class="form-control mb-2 w-full" value="{{ $item->dosage }}">

            <label class="block font-medium">Duration (days)</label>
            <input type="number" name="duration_days" class="form-control mb-2 w-full" value="{{ $item->duration_days }}">

            <div class="flex justify-between items-center mt-2">
                <button type="submit" class="btn btn-primary">Update</button>
        </form>

        {{-- Delete Form --}}
        <form class="delete-item-form" data-id="{{ $item->id }}" 
              action="{{ route('dashboard.doctor.prescription-items.destroy', $item->id) }}" 
              method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        </div>
    </div>
    @endforeach

    {{-- Final Save Button --}}
    <form method="GET" action="{{ route('dashboard.doctor.patients.show', $prescription->patient_id) }}">
        <button type="submit" class="btn btn-success mt-6">Save and Return to Patient</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Handle item update
    $('.update-item-form').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const id = form.data('id');
        const actionUrl = form.attr('action');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: form.serialize(),
            success: function () {
                alert('Updated successfully.');
            },
            error: function (xhr) {
                alert('Update failed: ' + xhr.responseText);
            }
        });
    });

    // Handle item delete
    $('.delete-item-form').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const id = form.data('id');
        const actionUrl = form.attr('action');

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: {
                _method: 'DELETE',
                _token: form.find('input[name="_token"]').val()
            },
            success: function () {
                $('#item-' + id).remove();
            },
            error: function (xhr) {
                alert('Delete failed: ' + xhr.responseText);
            }
        });
    });
});
</script>
@endsection
