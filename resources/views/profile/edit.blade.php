<x-app-layout>
    <div class="dashboard-wrapper" style="padding-top: 2rem;">
        <div style="max-width: 900px; margin: 0 auto; width: 100%;">
            <div class="animate-fade" style="margin-bottom: 3rem;">
                <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(to right, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Account Settings</h1>
                <p style="color: var(--text-muted); font-size: 1.1rem;">Manage your profile information and security preferences.</p>
            </div>

            <div class="glass-card animate-fade stagger-1" style="margin-bottom: 2.5rem; padding: 3rem;">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="glass-card animate-fade stagger-2" style="margin-bottom: 2.5rem; padding: 3rem;">
                @include('profile.partials.update-password-form')
            </div>

            <div class="glass-card animate-fade stagger-3" style="margin-bottom: 2.5rem; padding: 3rem; border-color: rgba(239, 68, 68, 0.2);">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
