<x-guest-layout>
    <div class="animate-fade">
        <h2 class="auth-title">Welcome Back</h2>
        <p class="auth-subtitle">Continue your journey with BBTL Task</p>
    </div>

    <!-- Social Logins -->
    <div class="animate-fade stagger-1" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; position: relative; z-index: 10;">
        <a href="javascript:void(0)" onclick="alert('Social login is currently in demo mode. Please use email/password.')" class="social-btn">
            <svg style="width: 20px;" viewBox="0 0 24 24"><path fill="currentColor" d="M12.48 10.92v3.28h7.84c-.24 1.84-.908 3.152-1.896 4.14-1.224 1.224-3.14 2.532-6.444 2.532-5.32 0-9.456-4.32-9.456-9.64s4.136-9.64 9.456-9.64c2.872 0 5.032 1.136 6.584 2.584l2.312-2.312C18.428 1.488 15.688 0 12 0 5.4 0 0 5.4 0 12s5.4 12 12 12c3.568 0 6.252-1.176 8.352-3.376 2.16-2.16 2.844-5.216 2.844-7.632 0-.712-.052-1.392-.16-2.072h-10.552z"/></svg>
            Google
        </a>
        <a href="javascript:void(0)" onclick="alert('Social login is currently in demo mode. Please use email/password.')" class="social-btn">
            <svg style="width: 20px;" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.477 2 2 6.477 2 12c0 4.419 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.341-3.369-1.341-.454-1.152-1.11-1.459-1.11-1.459-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482C19.138 20.161 22 16.416 22 12c0-5.523-4.477-10-10-10z"/></svg>
            GitHub
        </a>
    </div>

    <div class="divider animate-fade stagger-1">OR CONTINUE WITH</div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="animate-fade stagger-2">
        @csrf

        <!-- Email Address -->
        <div style="margin-bottom: 1.5rem;">
            <label for="email">Email Address</label>
            <div style="position: relative;">
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="admin@bbtl.com">
            </div>
            @error('email') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div style="margin-bottom: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label for="password" style="margin-bottom: 0.5rem;">Password</label>
            </div>
            <div style="position: relative;">
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            </div>
            @error('password') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <!-- Remember & Forgot -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0; cursor: pointer; font-size: 0.875rem;">
                <input id="remember_me" type="checkbox" name="remember" style="width: auto;">
                <span>Keep me logged in</span>
            </label>
            @if (Route::has('password.request'))
                <a style="color: var(--primary); text-decoration: none; font-size: 0.875rem; font-weight: 500;" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; font-size: 1rem; letter-spacing: 0.05em;">
            SIGN IN
        </button>

        @if (Route::has('register'))
            <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--text-muted);">
                New here? <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Create an account</a>
            </p>
        @endif
    </form>
</x-guest-layout>
