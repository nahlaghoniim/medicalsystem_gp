<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wessal | Healthcare System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />

    @yield('head')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tooltip (Optional) -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d5e86',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Top Navbar -->
    <nav class="bg-white shadow-sm z-10">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-primary font-bold text-lg">MedConnect</a>
            <div class="space-x-6">
                <a class="text-gray-700 hover:text-primary" href="{{ url('/doctor/dashboard') }}">Dashboard</a>
                <a class="text-gray-700 hover:text-primary" href="{{ route('dashboard.doctor.prescriptions.index') }}">Prescriptions</a>
                <a class="text-gray-700 hover:text-primary" href="{{ route('dashboard.doctor.patients.index') }}">Patients</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-primary font-semibold">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Page Layout -->
    <div class="flex flex-1">
        <!-- Sidebar could go here -->

        <!-- Main Content Area -->
        <main class="flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center text-gray-500 text-sm py-4 shadow-inner">
        © {{ now()->year }} MedConnect. All rights reserved.
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

    @stack('scripts')
</body>
</html>
