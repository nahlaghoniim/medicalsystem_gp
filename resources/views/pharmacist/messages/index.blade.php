@extends('layouts.pharmacist')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    
 <!-- Sidebar -->
<aside class="w-64 bg-white border-r flex flex-col justify-between">
    <div>
        <div class="p-6 flex items-center space-x-2">
            <img src="/images/wessal.png" class="h-8 w-8" alt="Logo">
            <span style="color: #1d5e86;" class="font-bold text-xl">WESAL</span>
        </div>
        <nav class="mt-4 space-y-1">

           <a href="{{ route('dashboard.pharmacist.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard') ? 'active' : '' }}">
   <i class="fas fa-home mr-3"></i> Dashboard
</a>

<a href="{{ route('dashboard.pharmacist.prescriptions.all') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/prescriptions') ? 'active' : '' }}">
   <i class="fas fa-prescription-bottle-alt mr-3"></i> Prescriptions
</a>

<a href="{{ route('dashboard.pharmacist.patients.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/patients') ? 'active' : '' }}">
   <i class="fas fa-user-injured mr-3"></i> Patient Records
</a>

<a href="{{ route('dashboard.pharmacist.messages.index') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/messages') ? 'active' : '' }}">
   <i class="fas fa-envelope mr-3"></i> Messages
</a>

<a href="{{ route('dashboard.pharmacist.settings') }}"
   class="sidebar-link {{ Request::is('pharmacist/dashboard/settings') ? 'active' : '' }}">
   <i class="fas fa-cog mr-3"></i> Settings
</a>

        </nav>
    </div>


        <!-- Bottom profile -->
        <div class="p-4 border-t">
            <div class="flex items-center space-x-3 mb-4">
                <img src="/images/profile.jpg" class="w-10 h-10 rounded-full" alt="User">
                <div class="text-sm font-semibold">
                    {{ auth()->user()->name }}
                </div>
                <div class="text-xs text-gray-500 capitalize">
                    {{ auth()->user()->role }}
                </div>
            </div>
            <!-- Logout Button -->
           <!-- Logout Button -->
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-gray-700 hover:text-red-500 transition text-xl" title="Logout">
        <i class="fas fa-sign-out-alt"></i>
    </button>
</form>

        </div>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-700">Messages</h1>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            @if($messages->isEmpty())
                <p class="text-gray-500">No messages found.</p>
            @else
                <div class="space-y-4">
                    @foreach($messages as $message)
                        <div class="flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                            <div>
                                <h4 class="font-semibold">{{ $message->sender_name }}</h4>
                                <p class="text-gray-600">{{ $message->subject }}</p>
                                <p class="text-sm text-gray-500">{{ $message->created_at->format('d/m/Y') }}</p>
                            </div>

                            <div class="flex items-center gap-4">
                                <span class="{{ $message->is_read ? 'text-green-600' : 'text-red-500' }} font-semibold">
                                    {{ $message->is_read ? 'Read' : 'Unread' }}
                                </span>

                                <form action="{{ route('dashboard.pharmacist.messages.toggle', $message->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-lg text-white" style="background-color: #1D5E86;">
                                        {{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
