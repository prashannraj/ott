<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Madhesh Films')</title>
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- HLS.js Latest Stable CDN (v1.5.15 as of Feb 2026) -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@1.5.15" crossorigin="anonymous"></script>
    
    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-expand-lg bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-danger" href="{{ route('home') }}">Madhesh Films</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('movies.index') }}">Movies</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shows.index') }}">TV Shows</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reels.index') }}">Reels</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('live.index') }}">Live TV</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('blog.index') }}">Blog</a></li>
                </ul>
                <div class="d-flex gap-3">
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-danger">Subscribe</a>
                    @auth
                        <span>{{ auth()->user()->name }}</span>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-5">
        @yield('content')
    </main>

    <footer class="bg-black py-4 mt-5">
        <div class="container text-center text-muted">
            © 2026 Madhesh Films. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>