@extends('layouts.main')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <x-dashboard.sidebar />
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-[#1D5E86]">Inbox</h2>

    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-[#1D5E86] text-white">
                <th class="py-3 px-4 text-left">Sender</th>
                <th class="py-3 px-4 text-left">Subject</th>
                <th class="py-3 px-4 text-left">Status</th>
                <th class="py-3 px-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($messages as $message)
                <tr class="border-b hover:bg-gray-100">
                    <td class="py-3 px-4">{{ $message->sender_name }}</td>
                    <td class="py-3 px-4">{{ $message->subject }}</td>
                    <td class="py-3 px-4">
                        @if($message->is_read)
                            <span class="text-green-600 font-medium">Read</span>
                        @else
                            <span class="text-red-500 font-medium">Unread</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-right space-x-2">
                        <a href="{{ route('dashboard.doctor.messages.show', $message->id) }}" class="text-blue-600 hover:underline">View</a>
                        <form action="{{ route('dashboard.doctor.messages.destroy', $message->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="py-4 text-center text-gray-500">No messages.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
