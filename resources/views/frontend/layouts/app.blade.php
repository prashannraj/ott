<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'OTT Platform')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> <!-- Tailwind -->
</head>
<body class="bg-gray-900 text-white">

    <header class="bg-gray-800">
        <nav class="container mx-auto flex justify-between p-4 items-center">
            <a href="{{ url('/') }}" class="text-2xl font-bold">OTT</a>
            <ul class="flex space-x-4">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/movies') }}">Movies</a></li>
                <li><a href="{{ url('/live') }}">Live</a></li>
                <li><a href="{{ url('/watchlist') }}">Watchlist</a></li>
            </ul>
        </nav>
    </header>

    <main class="container mx-auto mt-6">
        @yield('content')
    </main>

    <footer class="bg-gray-800 mt-12 p-4 text-center text-gray-400">
        &copy; {{ date('Y') }} OTT Platform
    </footer>

</body>
</html>
