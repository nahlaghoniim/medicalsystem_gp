@extends('layouts.main')

@section('content')
<div id="notification" class="hidden fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50"></div>

<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-xl mt-10">
    <h2 class="text-2xl font-bold text-[#1D5E86] mb-6">Edit Prescription for {{ $prescription->patient->name }}</h2>

    @foreach ($prescription->items as $item)
        <div class="mb-6 border rounded-xl shadow-sm bg-gray-50 p-6" id="item-{{ $item->id }}">
            <form class="update-item-form space-y-4" data-id="{{ $item->id }}" 
                  action="{{ route('dashboard.doctor.prescription-items.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700">Medicine Name</label>
                    <input type="text" name="medicine_name" value="{{ $item->medicine_name ?? $item->medication->name ?? '' }}"
                           class="w-full rounded-md border-gray-300 shadow-sm p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Dosage</label>
                    <input type="text" name="dosage" value="{{ $item->dosage }}"
                           class="w-full rounded-md border-gray-300 shadow-sm p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Duration (days)</label>
                    <input type="number" name="duration_days" value="{{ $item->duration_days }}"
                           class="w-full rounded-md border-gray-300 shadow-sm p-2">
                </div>

                <div class="flex justify-between items-center pt-4">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Update
                    </button>
                </div>
            </form>

            <form class="delete-item-form mt-2 text-right"
                  action="{{ route('dashboard.doctor.prescription-items.destroy', $item->id) }}"
                  method="POST" data-id="{{ $item->id }}">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </div>
    @endforeach

    <div class="text-right">
        <a href="{{ route('dashboard.doctor.patients.show', $prescription->patient_id) }}"
           class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
            Back to Patient Profile
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showMessage(message, isSuccess = true) {
        const notification = $('#notification');
        notification.removeClass('hidden').removeClass('bg-green-500 bg-red-500')
                   .addClass(isSuccess ? 'bg-green-500' : 'bg-red-500')
                   .text(message);
        setTimeout(() => notification.addClass('hidden'), 3000);
    }

    $(document).ready(function () {
        // UPDATE AJAX
        $('.update-item-form').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    showMessage(res.message || 'Updated successfully');
                },
                error: function (xhr) {
                    showMessage('Update failed', false);
                }
            });
        });

        // DELETE AJAX
        $('.delete-item-form').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);
            const id = form.data('id');
            const actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                },
                success: function (res) {
                    $('#item-' + id).remove();
                    showMessage(res.message || 'Deleted successfully');
                },
                error: function () {
                    showMessage('Delete failed', false);
                }
            });
        });
    });
</script>
@endsection
