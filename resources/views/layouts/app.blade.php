<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wessal</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- You can stack custom styles here if needed -->
    @stack('styles')
</head>

<body class="font-sans bg-gray-50">

    <!-- Navbar Section (Optional) -->
    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto flex items-center justify-between">
            <!-- Logo and Brand -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/wessal.png') }}" alt="Logo" class="h-10">
                <span class="text-2xl font-bold" style="color: #1d5e86;">Wessal</span>
            </div>
    
            <!-- Navigation Links -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('login') }}" class="text-lg hover:text-gray-600" style="color: #1d5e86;">Login</a>
                <a href="{{ route('register') }}" class="text-lg hover:text-gray-600" style="color: #1d5e86;">Sign Up</a>
            </div>
        </div>
    </nav>
    
    

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
