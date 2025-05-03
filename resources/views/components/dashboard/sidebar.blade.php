<aside class="w-64 bg-white p-6 shadow-lg flex flex-col justify-between h-screen hidden md:flex">
    <!-- Top: Logo and Nav -->
    <div>
        <div class="text-2xl font-bold text-primary mb-8">Wessal</div>

        <nav class="flex flex-col space-y-4 text-gray-600">
            <a href="{{ route('dashboard.doctor.index') }}" class="flex items-center gap-3 hover:text-primary @if(request()->routeIs('dashboard.doctor.index')) text-primary font-semibold @endif">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('dashboard.doctor.appointments.index') }}" class="flex items-center gap-3 hover:text-primary @if(request()->routeIs('dashboard.doctor.appointments.index')) text-primary font-semibold @endif">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
            <a href="{{ route('dashboard.doctor.patients.index') }}" class="flex items-center gap-3 hover:text-primary @if(request()->routeIs('dashboard.doctor.patients.index')) text-primary font-semibold @endif">
                <i class="fas fa-user-injured"></i> Patients
            </a>
            <a href="#" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-comment-medical"></i> Messages
            </a>
            <a href="{{ route('dashboard.doctor.medications.index') }}" class="flex items-center gap-3 hover:text-primary @if(request()->routeIs('dashboard.doctor.medications.index')) text-primary font-semibold @endif">
                <i class="fas fa-pills"></i> Medications
            </a>
            <a href="#" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-file-invoice-dollar"></i> Finances
            </a>
            <a href="{{ route('dashboard.doctor.settings.edit') }}" class="flex items-center gap-3 hover:text-primary @if(request()->routeIs('dashboard.doctor.settings.edit')) text-primary font-semibold @endif">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>
    </div>

  <!-- Bottom: Profile and Logout -->
<div class="border-t pt-4 mt-6">
    @php $user = Auth::user(); @endphp
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/doctor-avatar.png') }}" class="w-10 h-10 rounded-full object-cover" alt="Doctor Avatar">
            <div>
                <div class="text-sm font-semibold text-primary">{{ $user->name }}</div>
                <div class="text-xs text-gray-500 capitalize">{{ $user->role ?? 'Doctor' }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Logout" class="text-red-500 hover:text-red-700">
                <i class="fas fa-sign-out-alt text-lg"></i>
            </button>
        </form>
    </div>
</div>
</aside>
