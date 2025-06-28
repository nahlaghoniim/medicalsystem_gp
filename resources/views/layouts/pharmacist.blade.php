<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Pharmacist Dashboard - Wessal</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
.sidebar-link {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: #4a5568; /* gray-700 */
    border-radius: 0.5rem; /* rounded corners */
    transition: all 0.3s ease;
    font-weight: 500;
}

.sidebar-link:hover {
    color: #1d5e86;
}

.sidebar-link.active {
    background-color: #d6e7f1;
    color: #1d5e86;
    font-weight: 700;
}
</style>

    @stack('styles')
</head>
<body class="font-sans bg-gray-100 text-gray-800">
    @yield('content')
    @stack('scripts')
</body>
</html>
