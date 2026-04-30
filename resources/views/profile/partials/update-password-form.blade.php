<section>
    <header style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: white;">
            {{ __('Update Password') }}
        </h2>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="display: grid; gap: 1.5rem;">
        @csrf
        @method('put')

        <div class="glass-input-group">
            <label for="update_password_current_password" class="glass-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="glass-input" autocomplete="current-password" />
            @error('current_password', 'updatePassword') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <div class="glass-input-group">
            <label for="update_password_password" class="glass-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="glass-input" autocomplete="new-password" />
            @error('password', 'updatePassword') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <div class="glass-input-group">
            <label for="update_password_password_confirmation" class="glass-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="glass-input" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <button type="submit" class="btn-primary" style="padding: 1rem 3rem;">{{ __('Update Password') }}</button>

            @if (session('status') === 'password-updated')
                <p style="font-size: 0.875rem; color: var(--success);" class="animate-fade">{{ __('Password updated.') }}</p>
            @endif
        </div>
    </form>
</section>
