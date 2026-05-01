<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-blobs">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>
        
        <div class="hero-section" style="min-height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem;">
            <div style="margin-bottom: 2rem;">
                <a href="/" class="logo" style="font-size: 2rem;">
                    Workspace
                </a>
            </div>

            <div class="glass-card" style="width: 100%; max-width: 450px; padding: 3rem;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
