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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
@yield('scripts') <!-- ✅ Add this line -->

    @stack('scripts')
</body>
</html>
