@extends('layouts.main')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold text-[#1D5E86] mb-2">{{ $message->subject }}</h2>
        <p class="text-sm text-gray-500 mb-4">From: {{ $message->sender_name }} | {{ $message->created_at->format('d M Y, h:i A') }}</p>
        <p class="text-gray-700 leading-relaxed">{{ $message->content }}</p>
        <div class="mt-6">
            <a href="{{ route('dashboard.doctor.messages.index') }}" class="text-[#1D5E86] hover:underline">← Back to Inbox</a>
        </div>
    </div>
</div>
@endsection
