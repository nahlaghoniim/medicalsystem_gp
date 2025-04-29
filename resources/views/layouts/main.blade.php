<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <title>MedConnect | Healthcare System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- FullCalendar JS -->

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Custom Config (optional but good) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d5e86', // your main blue
                    }
                }
            }
        }
    </script>

    <!-- Optional custom styles -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-primary font-bold text-lg">MedConnect</a>
            <div class="space-x-6">
                <a class="text-gray-700 hover:text-primary" href="{{ url('/doctor/dashboard') }}">Dashboard</a>
                <a class="text-gray-700 hover:text-primary" href="{{ route('dashboard.doctor.prescriptions.index') }}">Prescriptions</a>
                <a class="text-gray-700 hover:text-primary" href="{{ route('dashboard.doctor.patients.index') }}">Patients</a>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-primary font-semibold">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-1 container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-gray-500 text-sm py-4 mt-8 shadow-inner">
        © {{ now()->year }} MedConnect. All rights reserved.
    </footer>

</body>
</html>
