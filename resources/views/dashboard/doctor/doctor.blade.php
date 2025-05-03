@extends('layouts.main')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

<div class="flex bg-gray-50 min-h-screen font-sans text-gray-800">
    <!-- Sidebar -->
    <x-dashboard.sidebar />

    <!-- Main Content -->
    <div class="flex-1 p-6 space-y-6">
        <!-- Top Bar -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Dashboard</h1>
            <div class="flex items-center gap-4">
                <input type="text" placeholder="Search" class="border rounded-lg px-4 py-2 shadow-sm focus:outline-none">
                <a href="{{ route('dashboard.doctor.patients.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    + Add Patient
                </a>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $cards = [
                    ['label' => 'Total Patients', 'value' => $patientsCount, 'icon' => 'fa-users', 'growth' => '21%'],
                    ['label' => 'New Patients', 'value' => $newPatientsToday, 'icon' => 'fa-user-plus', 'growth' => '4.4%'],
                    ['label' => "Today's Appointments", 'value' => $todayAppointments->count(), 'icon' => 'fa-calendar-check', 'growth' => '27%'],
                    ['label' => 'Total Payments', 'value' => '$' . number_format($totalPayments, 2), 'icon' => 'fa-dollar-sign', 'growth' => '37%'],
                ];
            @endphp

            @foreach($cards as $card)
                <div class="bg-white rounded-xl shadow p-5 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500">{{ $card['label'] }}</div>
                        <i class="fas {{ $card['icon'] }} text-blue-600"></i>
                    </div>
                    <div class="text-2xl font-bold">{{ $card['value'] }}</div>
                    <div class="text-green-500 text-sm">+{{ $card['growth'] }}</div>
                </div>
            @endforeach
        </div>

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column: Calendar + Activity -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Calendar -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold">Calendar</h2>
                        <span class="text-sm text-gray-400">{{ \Carbon\Carbon::now()->format('g:i A') }}</span>
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
                <!-- Upcoming Appointment -->
                <div class="bg-[#1D5E86] text-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-2">Upcoming Appointment</h2>
                    @if($upcomingAppointment)
                        <p class="text-sm"><strong>{{ $upcomingAppointment->patient->name }}</strong></p>
                        <p class="text-xs">Today • {{ \Carbon\Carbon::parse($upcomingAppointment->appointment_time)->format('g:i A') }}</p>
                    @else
                        <p class="text-sm text-gray-100">No upcoming appointment</p>
                    @endif
                </div>

                <!-- Today's Schedule -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Today's Schedule</h2>
                    <ul class="space-y-3">
                        @forelse($todayAppointments as $appointment)
                            <li class="flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-sm">{{ $appointment->patient->name }}</p>
                                    <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                    @class([
                                        'bg-green-100 text-green-700' => $appointment->status === 'In progress',
                                        'bg-red-100 text-red-700' => $appointment->status === 'Cancelled',
                                        'bg-yellow-100 text-yellow-700' => $appointment->status === 'Rescheduled',
                                        'bg-gray-100 text-gray-700' => !in_array($appointment->status, ['In progress', 'Cancelled', 'Rescheduled'])
                                    ])">
                                    {{ $appointment->status }}
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-400 text-center">No appointments today.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Treatment Status -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h2 class="text-lg font-semibold mb-4">Patient Treatment Status</h2>
                    <canvas id="treatmentStatusChart" class="h-60 w-full"></canvas>
                </div>
            </div>
        </div>

     <!-- Latest Appointments (Full Width Section) -->
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
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('m/d/Y') }}</td>
                        <td>{{ $appointment->patient->condition ?? '—' }}</td>
                        <td>
                            @php
                                $treatmentStatus = $appointment->patient->condition_status ?? 'Unknown';
                                $badgeClasses = 'bg-gray-100 text-gray-600';

                                if ($treatmentStatus === 'Stable') {
                                    $badgeClasses = 'bg-green-100 text-green-700';
                                } elseif ($treatmentStatus === 'Urgent') {
                                    $badgeClasses = 'bg-yellow-100 text-yellow-700';
                                } elseif ($treatmentStatus === 'Emergency') {
                                    $badgeClasses = 'bg-red-100 text-red-700';
                                }
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClasses }}">
                                {{ $treatmentStatus }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-4">No recent appointments.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($calendarAppointments),
                height: 300,
                eventClick: function (info) {
                    const date = info.event.start.toLocaleDateString();
                    const title = info.event.title;
                    alert(`Appointment on ${date}\n${title}`);
                },
                dayCellDidMount: function (info) {
                    info.el.addEventListener('mouseenter', () => info.el.classList.add('bg-blue-50'));
                    info.el.addEventListener('mouseleave', () => info.el.classList.remove('bg-blue-50'));
                }
            }).render();
        }

        const revenueData = @json($revenueData);
        const appointmentsData = @json($appointmentsData);
        const activityLabels = @json($activityLabels);

        let currentDataset = 'revenue';
        const activityCtx = document.getElementById('activityChart')?.getContext('2d');
        let activityChart;
        if (activityCtx) {
            activityChart = new Chart(activityCtx, {
                type: 'bar',
                data: {
                    labels: activityLabels,
                    datasets: [{
                        label: 'Revenue',
                        data: revenueData,
                        backgroundColor: '#60a5fa',
                        borderColor: '#3b82f6',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            document.getElementById('activityType')?.addEventListener('change', (e) => {
                currentDataset = e.target.value;
                const newData = currentDataset === 'revenue' ? revenueData : appointmentsData;
                const newLabel = currentDataset === 'revenue' ? 'Revenue' : 'Appointments';
                const newColor = currentDataset === 'revenue' ? '#60a5fa' : '#fca5a5';
                const newBorderColor = currentDataset === 'revenue' ? '#3b82f6' : '#fb7185';

                activityChart.data.datasets[0].label = newLabel;
                activityChart.data.datasets[0].data = newData;
                activityChart.data.datasets[0].backgroundColor = newColor;
                activityChart.data.datasets[0].borderColor = newBorderColor;
                activityChart.update();
            });
        }

        const treatmentCtx = document.getElementById('treatmentStatusChart')?.getContext('2d');
        if (treatmentCtx) {
            new Chart(treatmentCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Recovered', 'Under Treatment', 'Critical'],
                    datasets: [{
                        data: [70, 20, 10],
                        backgroundColor: ['#1B8332', '#1D5E86', '#D300'],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutout: '70%',
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#0E0F11',
                                boxWidth: 10
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
