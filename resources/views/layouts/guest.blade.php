<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- PWA & App Icons Setup -->
    <meta name="theme-color" content="#e50914">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Madhesh Films">

    <title>{{ config('app.name', 'FCPB PORTAL') }}</title>

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Icons (PWA + Apple + Favicon) -->
    <link rel="icon" href="{{ asset('icons/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icons/web-app-manifest-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('icons/web-app-manifest-512x512.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-light min-vh-100 d-flex flex-column">
    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center p-4">
        <!-- Logo -->
        <div class="mb-4 text-center">
            <a href="/">
                    <!-- Updated logo path -->
                    <img
                        src="{{ asset('icons/web-app-manifest-192x192.png') }}"
                        alt="FCPB Logo"
                        class="img-fluid shadow-lg rounded-circle"
                        style="width: 100px; height: 100px; object-fit: contain;"
                    />
                </a>
        </div>

        <!-- Main Content Card -->
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 450px;">
            <div class="card-body p-4 p-sm-5">
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Footer (optional, mobile friendly) -->
    <footer class="mt-auto py-4 text-center text-muted small">
        © {{ date('Y') }} Film and Mass Communication Promotion Board. All rights reserved.
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
