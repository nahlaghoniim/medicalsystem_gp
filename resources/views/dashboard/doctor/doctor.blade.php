@extends('layouts.main')

@section('content')
<div class="flex bg-gray-100 min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white p-6 shadow-lg space-y-6 hidden md:block">
        <div class="text-2xl font-bold text-primary mb-8">MedConnect</div>
        <nav class="flex flex-col space-y-4 text-gray-600">
            <a href="{{ route('dashboard.doctor') }}" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('dashboard.doctor.appointments.index') }}" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
            <a href="{{ route('dashboard.doctor.patients.index') }}" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-user-injured"></i> Patients
            </a>
            <a href="#" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-comment-medical"></i> Messages
            </a>
            <a href="{{ route('dashboard.doctor.prescriptions.index') }}" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-pills"></i> Medications
            </a>
            
            <a href="#" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-file-invoice-dollar"></i> Finances
            </a>
            <a href="#" class="flex items-center gap-3 hover:text-primary">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-8 space-y-8">

        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary">Welcome, Dr. {{ Auth::user()->name }}</h1>
            <a href="{{ route('dashboard.doctor.patients.create') }}" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">
                + Add Patient
            </a>
        </div>

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow flex flex-col items-center justify-center text-center">
                <h2 class="text-gray-500 text-sm">Total Patients</h2>
                <p class="text-3xl font-bold">{{ $patientsCount }}</p>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow flex flex-col items-center justify-center text-center">
                <h2 class="text-gray-500 text-sm">New Patients</h2>
                <p class="text-3xl font-bold">{{ $newPatientsToday }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow flex flex-col items-center justify-center text-center">
                <h2 class="text-gray-500 text-sm">Today's Appointments</h2>
                <p class="text-3xl font-bold">{{ $todayAppointments->count() }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow flex flex-col items-center justify-center text-center">
                <h2 class="text-gray-500 text-sm">Total Payments</h2>
                <p class="text-3xl font-bold">${{ $totalPayments }}</p>
            </div>
        </div>

        <!-- Calendar and Details Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">

            <!-- Calendar & Activity -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Calendar -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-bold mb-4">Calendar</h2>
                    <div id="calendar" class="h-72 bg-gray-100 rounded-lg"></div>
                </div>

                <!-- Activity Overview -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-bold mb-4">Activity Overview</h2>
                    <canvas id="activityChart" class="h-64"></canvas>
                </div>

            </div>

            <!-- Right Side: Upcoming Appointments + Patient Status -->
            <div class="space-y-8">

                <!-- Upcoming Appointment -->
                <div class="bg-primary text-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-bold mb-4">Upcoming Appointment</h2>
                    @if($upcomingAppointment)
                        <div class="space-y-2">
                            <p><strong>Patient:</strong> {{ $upcomingAppointment->patient->name }}</p>
                            <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($upcomingAppointment->appointment_time)->format('h:i A') }}</p>
                            <p><strong>Status:</strong> {{ $upcomingAppointment->status }}</p>
                        </div>
                    @else
                        <p class="text-gray-100">No upcoming appointment.</p>
                    @endif
                </div>

                <!-- Today's Schedule -->
                <div class="bg-white p-6 rounded-2xl shadow">
                    <h2 class="text-xl font-bold mb-4">Today's Schedule</h2>
                    <ul class="space-y-4">
                        @forelse($todayAppointments as $appointment)
                            <li class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $appointment->patient->name }}</p>
                                    <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($appointment->status == 'In progress') bg-green-100 text-green-700
                                    @elseif($appointment->status == 'Cancelled') bg-red-100 text-red-700
                                    @elseif($appointment->status == 'Rescheduled') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-700
                                    @endif
                                ">
                                    {{ $appointment->status }}
                                </span>
                            </li>
                        @empty
                            <li class="text-gray-400 text-center">No appointments today.</li>
                        @endforelse
                    </ul>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    {
                        title: 'Meeting with John',
                        start: new Date().toISOString().slice(0, 10),
                        allDay: true
                    },
                ]
            });
            calendar.render();
        }

        var ctx = document.getElementById('activityChart').getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Appointments',
                        data: [12, 19, 3, 5, 2, 3, 7],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
</script>
@endsection
