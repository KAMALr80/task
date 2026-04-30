<x-guest-layout>
    <div class="animate-fade">
        <h2 class="auth-title">Join the Team</h2>
        <p class="auth-subtitle">Create an account to start collaborating</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="animate-fade stagger-1">
        @csrf

        <!-- Name -->
        <div style="margin-bottom: 1.25rem;">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe">
            @error('name') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <!-- Email Address -->
        <div style="margin-bottom: 1.25rem;">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="john@example.com">
            @error('email') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div style="margin-bottom: 1.25rem;">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            @error('password') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 2rem;">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem;">
            Register
        </button>

        <p style="text-align: center; margin-top: 2rem; font-size: 0.875rem; color: var(--text-muted);">
            Already have an account? <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Log in here</a>
        </p>
    </form>
</x-guest-layout>
