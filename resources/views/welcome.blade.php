<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Workspace') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .hero-section {
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 2rem;
            }
            .hero-title {
                font-size: 4rem;
                font-weight: 800;
                margin-bottom: 1.5rem;
                background: linear-gradient(to right, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .hero-subtitle {
                font-size: 1.25rem;
                color: var(--text-muted);
                max-width: 600px;
                margin-bottom: 3rem;
                line-height: 1.6;
            }
            .cta-group {
                display: flex;
                gap: 1.5rem;
            }
            .btn-outline {
                background: var(--glass);
                border: 1px solid var(--glass-border);
                color: white;
                padding: 0.75rem 2rem;
                border-radius: 1rem;
                font-weight: 600;
                text-decoration: none;
                transition: 0.3s;
            }
            .btn-outline:hover {
                background: var(--glass-hover);
                border-color: white;
            }
        </style>
    </head>
    <body class="dark" style="background: #0f172a; color: white;">
        <div class="bg-blobs">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
        </div>
        <div class="hero-section">
            <div class="glass-card animate-fade" style="padding: 5rem 4rem; max-width: 850px; border-radius: 3.5rem;">
                <h1 class="hero-title" style="border: none; margin-bottom: 2rem;">Workspace Manager</h1>
                <p class="hero-subtitle">
                    Experience the future of team collaboration. Manage projects, assign tasks, and track progress with our ultra-premium glassmorphic interface.
                </p>
                
                <div class="cta-group" style="display: flex; align-items: center; justify-content: center; gap: 2rem;">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary" style="padding: 1.2rem 4rem; font-size: 1.1rem; border-radius: 1.2rem;">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-primary" style="padding: 1.2rem 4rem; font-size: 1.1rem; border-radius: 1.2rem;">Get Started</a>
                        <a href="{{ route('register') }}" class="btn-outline" style="padding: 1.2rem 4rem; font-size: 1.1rem; border-radius: 1.2rem; background: rgba(255,255,255,0.05);">Register Account</a>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
