<aside class="w-64 bg-white border-r flex flex-col justify-between">
    <!-- Logo and Navigation -->
    <div>
        <div class="p-6 flex items-center space-x-2">
            <img src="/images/wessal.png" class="h-8 w-8" alt="Logo">
            <span class="font-bold text-xl" style="color: #1D5E86;">WESSAL</span>
        </div>

        <nav class="mt-4 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('dashboard.doctor.index') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.index') ? 'active-link' : '' }}">
                <i class="fas fa-home mr-3"></i> Dashboard
            </a>

            <!-- Appointments -->
            <a href="{{ route('dashboard.doctor.appointments.index') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.appointments.index') ? 'active-link' : '' }}">
                <i class="fas fa-calendar-check mr-3"></i> Appointments
            </a>

            <!-- Patients -->
            <a href="{{ route('dashboard.doctor.patients.index') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.patients.index') ? 'active-link' : '' }}">
                <i class="fas fa-user-injured mr-3"></i> Patients
            </a>

            <!-- Messages -->
            <a href="{{ route('dashboard.doctor.messages.index') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.messages.index') ? 'active-link' : '' }}">
                <i class="fas fa-comments mr-3"></i> Messages
            </a>

            <!-- Medications -->
            <a href="{{ route('dashboard.doctor.medications.index') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.medications.index') ? 'active-link' : '' }}">
                <i class="fas fa-pills mr-3"></i> Medications
            </a>

            <!-- Finances -->
            <a href="{{ route('dashboard.doctor.payments.index') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.payments.index') ? 'active-link' : '' }}">
                <i class="fas fa-wallet mr-3"></i> Finances
            </a>

            <!-- Settings -->
            <a href="{{ route('dashboard.doctor.settings.edit') }}"
                class="sidebar-link {{ request()->routeIs('dashboard.doctor.settings.edit') ? 'active-link' : '' }}">
                <i class="fas fa-cog mr-3"></i> Settings
            </a>
        </nav>
    </div>

    <!-- Bottom profile -->
    <div class="p-4 border-t">
        <div class="flex items-center space-x-3 mb-4">
            <img src="{{ asset('images/sara.jpg') }}" class="w-10 h-10 rounded-full object-cover" alt="Doctor Avatar">
            <div>
                <div class="text-sm font-semibold text-[#1D5E86]">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500 capitalize">{{ auth()->user()->role ?? 'Doctor' }}</div>
            </div>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-700 hover:text-red-500 transition text-xl" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</aside>

<!-- ✅ Sidebar styles -->
<style>
.sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: #4a5568; /* gray-700 */
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.sidebar-link:hover {
    color: #1D5E86;
    background-color: #eaf3f8;
}

.sidebar-link.active-link {
    background-color: #d6e7f1;
    color: #1D5E86;
    font-weight: 700;
}
</style>
