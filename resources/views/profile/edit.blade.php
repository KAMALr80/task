<x-app-layout>
    <div class="dashboard-wrapper" style="padding: 3rem 2rem; display: flex; justify-content: center;" x-data="{ section: 'profile' }">
        <div class="glass-card animate-fade" style="width: 100%; max-width: 1100px; padding: 0; display: grid; grid-template-columns: 280px 1fr; overflow: hidden; border-radius: 2rem; min-height: 700px;">
            <!-- Internal Settings Navigation -->
            <div style="background: rgba(255,255,255,0.02); border-right: 1px solid var(--glass-border); padding: 3rem 2rem;">
                <div style="margin-bottom: 3rem; text-align: center;">
                    <div style="width: 70px; height: 70px; border-radius: 20px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; color: white; margin: 0 auto 1.5rem; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h2 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.25rem;">{{ auth()->user()->name }}</h2>
                    <p style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">{{ auth()->user()->role }}</p>
                </div>

                <nav style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <button @click="section = 'profile'" :class="section === 'profile' ? 'active' : ''" class="settings-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Profile Info
                    </button>
                    <button @click="section = 'security'" :class="section === 'security' ? 'active' : ''" class="settings-nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Security
                    </button>
                    <div style="height: 1px; background: var(--glass-border); margin: 1rem 0;"></div>
                    <button @click="section = 'danger'" :class="section === 'danger' ? 'active' : ''" class="settings-nav-link" style="color: var(--danger);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                        Delete Account
                    </button>
                </nav>
            </div>

            <!-- Content Area -->
            <div style="padding: 4rem; max-height: 80vh; overflow-y: auto;">
                <!-- Profile Section -->
                <div x-show="section === 'profile'" x-transition:enter="animate-fade">
                    <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Profile Information</h1>
                    <p style="color: var(--text-muted); margin-bottom: 3rem;">Update your account's profile information and email address.</p>
                    <div style="max-width: 600px;">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Security Section -->
                <div x-show="section === 'security'" x-transition:enter="animate-fade" style="display: none;">
                    <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Security Settings</h1>
                    <p style="color: var(--text-muted); margin-bottom: 3rem;">Ensure your account is using a long, random password to stay secure.</p>
                    <div style="max-width: 600px;">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Section -->
                <div x-show="section === 'danger'" x-transition:enter="animate-fade" style="display: none;">
                    <h1 style="font-size: 2rem; font-weight: 800; color: var(--danger); margin-bottom: 0.5rem;">Danger Zone</h1>
                    <p style="color: var(--text-muted); margin-bottom: 3rem;">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                    <div style="max-width: 600px; padding: 2rem; background: rgba(239, 68, 68, 0.05); border-radius: 1.5rem; border: 1px solid rgba(239, 68, 68, 0.1);">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .settings-nav-link {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            border-radius: 1rem;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            text-align: left;
        }
        .settings-nav-link:hover {
            background: var(--glass);
            color: var(--text-color);
        }
        .settings-nav-link.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        }
    </style>
</x-app-layout>
