<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MedConnect</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- You can stack custom styles here if needed -->
    @stack('styles')
</head>

<body class="font-sans bg-gray-50">

    <!-- Navbar Section (Optional) -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-white font-semibold text-2xl">Smart Healthcare</a>
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="text-white hover:text-gray-200">Login</a>
                <a href="{{ route('register') }}" class="text-white hover:text-gray-200">Sign Up</a>
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
