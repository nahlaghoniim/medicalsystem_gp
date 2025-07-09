<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WESAL</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- You can stack custom styles here if needed -->
    @stack('styles')
</head>

<body class="font-[Inter] text-[#292D32]"> <!-- ✅ You missed this tag -->

    <div id="app">
        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Optional JavaScript (Alpine.js for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

    <!-- Stack for any additional scripts -->
    @stack('scripts')

</body>

</html>
