@extends('layouts.main')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />

<div class="flex bg-gray-50 min-h-screen font-sans text-gray-800">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-6 space-y-6">
        <!-- Top Bar -->
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 bg-white px-4 py-2 w-80 rounded-full shadow-sm border">
                <i class="fas fa-search text-gray-400"></i>
                <input type="text" placeholder="Search" class="w-full text-sm outline-none" />
            </div>
            <div class="flex items-center gap-4">
                 <a href="{{ route('dashboard.doctor.patients.create') }}"
                 class="bg-[#1D5E86] text-white px-4 py-2 rounded-lg hover:bg-blue-700">+ Add Patient</a>
                <i class="fas fa-bell text-gray-500"></i>
                <img src="{{ asset('images/sara.jpg') }}" class="w-10 h-10 rounded-full border" />
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['Total Patients', $patientsCount ?? 120, 'fa-users', '21%'],
                ['New Patients', 5, 'fa-user-plus', '4.4%'],
                ["Today's Appointments", 3, 'fa-calendar-check', '27%'],
                ['Total Payments', '$2,450.00', 'fa-dollar-sign', '37%']
            ] as [$label, $value, $icon, $growth])
                <div class="bg-white p-5 rounded-xl shadow flex flex-col gap-2">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-500">{{ $label }}</div>
                        <i class="fas {{ $icon }} text-blue-600"></i>
                    </div>
                    <div class="text-2xl font-bold">{{ $value }}</div>
                    <div class="text-green-500 text-sm">+{{ $growth }}</div>
                </div>
            @endforeach
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Calendar -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Calendar</h2>
                        <span class="text-sm text-gray-400">{{ now()->format('g:i A') }}</span>
                    </div>
                    <div id="calendar" class="min-h-[16rem]"></div>
                </div>

                <!-- Activity Chart -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-lg font-semibold">Activity Overview</h2>
                        <div class="flex gap-2">
                            <select id="activityType" class="border px-2 py-1 text-sm rounded">
                                <option value="revenue">Revenue</option>
                                <option value="appointments">Appointments</option>
                            </select>
                            <select id="activityRange" class="border px-2 py-1 text-sm rounded">
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <canvas id="activityChart" class="w-full h-60"></canvas>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-6">
                <!-- Upcoming Appointment (Static) -->
                <div class="bg-[#1D5E86] text-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-2">Upcoming Appointment</h2>
                    <p class="text-sm font-semibold">Mohamed Youssef</p>
                    <p class="text-xs">10:30 AM</p>
                </div>

                <!-- Today's Schedule (Static) -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Today's Schedule</h2>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-sm">Ahmed Samir</p>
                                <p class="text-xs text-gray-400">9:00 AM</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                In progress
                            </span>
                        </li>
                        <li class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold text-sm">Sara Khaled</p>
                                <p class="text-xs text-gray-400">11:00 AM</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                Rescheduled
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Treatment Status Chart -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Patient Treatment Status</h2>
                    <canvas id="treatmentStatusChart" class="h-60 w-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Latest Appointments Table -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Latest Appointments</h2>
                <div class="text-sm text-gray-500">
                    <select class="border px-2 py-1 rounded">
                        <option>Last 24h</option>
                        <option>Last 7d</option>
                        <option>Last 30d</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="text-gray-400">
                        <tr>
                            <th class="pb-3">Patient Name</th>
                            <th class="pb-3">Age</th>
                            <th class="pb-3">Date</th>
                            <th class="pb-3">Diagnosis</th>
                            <th class="pb-3">Treatment Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($latestAppointments as $appointment)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->patient->name) }}" alt="{{ $appointment->patient->name }}" class="w-8 h-8 rounded-full">
                                    <div>
                                        <div class="font-semibold">{{ $appointment->patient->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $appointment->patient->job_title ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>{{ $appointment->patient->age }} Years</td>
                                <td>{{ $appointment->appointment_time ? $appointment->appointment_time->format('m/d/Y') : '—' }}</td>
                                <td>{{ $appointment->patient->condition ?? '—' }}</td>
                                <td>
                                    @php
                                        $status = $appointment->patient->condition_status ?? 'Unknown';
                                        $badge = match($status) {
                                            'Stable' => 'bg-green-100 text-green-700',
                                            'Urgent' => 'bg-yellow-100 text-yellow-700',
                                            'Emergency' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-gray-400 py-4">No recent appointments.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Calendar
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    { title: 'Checkup: Ali', date: '{{ now()->toDateString() }}' },
                    { title: 'Follow-up: Mariam', date: '{{ now()->addDays(2)->toDateString() }}' }
                ]
            }).render();
        }

        // Treatment Status Chart
        const treatmentCtx = document.getElementById('treatmentStatusChart')?.getContext('2d');
        if (treatmentCtx) {
            new Chart(treatmentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Recovered', 'Under Treatment', 'Critical'],
                    datasets: [{
                        data: [70, 20, 10],
                        backgroundColor: ['#1B8332', '#1D5E86', '#D30000'],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }

        // Activity Chart
        const ctx = document.getElementById('activityChart')?.getContext('2d');
        if (ctx) {
            const revenueData = [200, 400, 300, 500, 450, 600, 700];
            const appointmentsData = [5, 7, 4, 6, 8, 9, 10];
            const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

            const chartColors = {
                revenue: { bg: '#60a5fa', border: '#3b82f6', label: 'Revenue' },
                appointments: { bg: '#fca5a5', border: '#fb7185', label: 'Appointments' }
            };

            const activityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: chartColors.revenue.label,
                        data: revenueData,
                        backgroundColor: chartColors.revenue.bg,
                        borderColor: chartColors.revenue.border,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: { y: { beginAtZero: true } }
                }
            });

            document.getElementById('activityType')?.addEventListener('change', function (e) {
                const type = e.target.value;
                const selected = chartColors[type];
                activityChart.data.datasets[0].label = selected.label;
                activityChart.data.datasets[0].data = type === 'revenue' ? revenueData : appointmentsData;
                activityChart.data.datasets[0].backgroundColor = selected.bg;
                activityChart.data.datasets[0].borderColor = selected.border;
                activityChart.update();
            });
        }
    });
</script>
@endsection
