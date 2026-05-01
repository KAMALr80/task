<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Workspace') }}</title>

        <script>
            // Global Theme Logic
            window.toggleTheme = function() {
                const html = document.documentElement;
                const isDark = html.classList.contains('dark');
                const newTheme = isDark ? 'light' : 'dark';
                html.classList.remove('dark', 'light');
                html.classList.add(newTheme);
                localStorage.setItem('theme', newTheme);
                window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: newTheme } }));
            };

            // Apply theme immediately
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.classList.add(savedTheme);

            // Listen for Session Notifications
            window.addEventListener('load', () => {
                @if(session('success'))
                    window.dispatchEvent(new CustomEvent('notify', { detail: { message: "{{ session('success') }}", type: 'success' } }));
                @endif
                @if(session('error'))
                    window.dispatchEvent(new CustomEvent('notify', { detail: { message: "{{ session('error') }}", type: 'error' } }));
                @endif
            });
        </script>

        <style>
            /* Critical Theme Variables & Overrides */
            html.dark {
                --bg-color: #0f172a !important;
                --card-bg: rgba(30, 41, 59, 0.7) !important;
                --text-color: #f8fafc !important;
                --text-muted: #94a3b8 !important;
                --sidebar-bg: rgba(15, 23, 42, 0.9) !important;
                --glass: rgba(255, 255, 255, 0.03) !important;
                --glass-border: rgba(255, 255, 255, 0.1) !important;
                --glow: rgba(99, 102, 241, 0.15) !important;
            }
            html.light {
                --bg-color: #ffffff !important;
                --card-bg: #f8fafc !important;
                --text-color: #000000 !important;
                --text-muted: #475569 !important;
                --sidebar-bg: #ffffff !important;
                --glass: rgba(0, 0, 0, 0.05) !important;
                --glass-border: rgba(0, 0, 0, 0.1) !important;
                --glow: none !important;
            }

            /* Direct UI Overrides */
            body, .dashboard-wrapper {
                background-color: var(--bg-color) !important;
                background-image: none !important; /* Force remove dark gradients */
                color: var(--text-color) !important;
                transition: none !important; /* Instant switch for debugging */
            }

            .sidebar, .top-nav, .glass-card, table, tr, td, th {
                background-color: var(--card-bg) !important;
                background-image: none !important;
                color: var(--text-color) !important;
                border-color: var(--glass-border) !important;
            }

            .nav-link, .stat-label, .dropdown-item, .custom-table th, .custom-table td {
                color: var(--text-color) !important;
            }

            h1, h2, h3, h4, h5, h6, span, p, div {
                color: var(--text-color) !important;
            }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" x-data="{ dark: document.documentElement.classList.contains('dark') }" @theme-changed.window="dark = $event.detail.theme === 'dark'">
        <!-- Toast Notifications Container -->
        <div x-data="{ 
                notifications: [],
                add(message, type = 'success') {
                    const id = Date.now();
                    this.notifications.push({ id, message, type });
                    setTimeout(() => {
                        this.notifications = this.notifications.filter(n => n.id !== id);
                    }, 5000);
                }
             }"
             @notify.window="add($event.detail.message, $event.detail.type)"
             class="toast-container">
            <template x-for="notification in notifications" :key="notification.id">
                <div class="toast-item" :class="'toast-' + notification.type" 
                     x-show="true"
                     x-transition:enter="toast-enter"
                     x-transition:leave="toast-leave">
                    <div class="toast-icon">
                        <template x-if="notification.type === 'success'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></template>
                        <template x-if="notification.type === 'error'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></template>
                    </div>
                    <div x-text="notification.message"></div>
                    <button @click="notifications = notifications.filter(n => n.id !== notification.id)" class="toast-close">&times;</button>
                </div>
            </template>
        </div>

        <div class="dashboard-wrapper">
            @include('layouts.sidebar')

            <main class="main-content" style="padding: 0;">
                <!-- Fixed Top Navigation Bar -->
                <header class="top-nav" style="display: flex; justify-content: flex-end; align-items: center; padding: 1rem 2.5rem; background: var(--sidebar-bg); backdrop-filter: blur(15px); border-bottom: 1px solid var(--glass-border); position: sticky; top: 0; z-index: 1000; height: 70px;">
                    <div style="display: flex; align-items: center; gap: 1.5rem;">
                        <!-- Theme Toggle -->
                        <button @click="window.toggleTheme()" class="profile-trigger" style="width: 40px; height: 40px; border-radius: 12px; background: var(--glass); border: 1px solid var(--glass-border); color: var(--text-color); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.3s;">
                            <template x-if="dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><path d="M12 1v2"/><path d="M12 21v2"/><path d="M4.22 4.22l1.42 1.42"/><path d="M18.36 18.36l1.42 1.42"/><path d="M1 12h2"/><path d="M21 12h2"/><path d="M4.22 19.78l1.42-1.42"/><path d="M18.36 5.64l1.42-1.42"/></svg>
                            </template>
                            <template x-if="!dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                            </template>
                        </button>

                        <div class="profile-trigger-wrapper" x-data="{ open: false }" @click.away="open = false" style="position: relative;">
                        <!-- Circular Avatar -->
                        <div class="profile-trigger" @click="open = !open" style="width: 45px; height: 45px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; cursor: pointer; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 4px 15px rgba(0,0,0,0.3); transition: 0.3s;">
                            <span style="font-size: 1.2rem; font-weight: 800; color: white; line-height: 1; pointer-events: none;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>

                        <!-- Proper Glass Dropdown -->
                        <div class="profile-dropdown" 
                             x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 transform scale-95 translate-y-2"
                             style="position: absolute; top: 55px; right: 0; width: 220px; background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(25px); border: 1px solid var(--glass-border); border-radius: 1.25rem; padding: 0.75rem; box-shadow: 0 20px 40px rgba(0,0,0,0.6); z-index: 1000;"
                             class="animate-fade">
                            <div style="padding: 0.75rem 1rem; border-bottom: 1px solid var(--glass-border); margin-bottom: 0.5rem; text-align: center;">
                                <div style="font-weight: 700; color: white; font-size: 0.95rem;">{{ auth()->user()->name }}</div>
                                <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.2rem;">{{ auth()->user()->role }}</div>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}" class="dropdown-item" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; color: #cbd5e1; text-decoration: none; border-radius: 0.75rem; transition: 0.2s; font-size: 0.9rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                My Profile
                            </a>
                            
                            <div style="height: 1px; background: var(--glass-border); margin: 0.4rem 0;"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width: 100%; border: none; background: none; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; color: #ef4444; border-radius: 0.75rem; transition: 0.2s; font-size: 0.9rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                </header>

                <div style="padding: 2.5rem;">
                @isset($header)
                    <div class="header-section">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
