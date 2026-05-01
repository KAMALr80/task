<section>
    <form method="post" action="{{ route('profile.update') }}" style="display: grid; gap: 1.5rem;">
        @csrf
        @method('patch')

        <div class="glass-input-group">
            <label for="name" class="glass-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="glass-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name') <div class="input-error">{{ $message }}</div> @enderror
        </div>

        <div class="glass-input-group">
            <label for="email" class="glass-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="glass-input" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email') <div class="input-error">{{ $message }}</div> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 1rem;">
                    <p style="font-size: 0.875rem; color: var(--warning);">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" style="background: none; border: none; color: var(--primary); text-decoration: underline; cursor: pointer; padding: 0;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 0.5rem; font-weight: 500; font-size: 0.875rem; color: var(--success);">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <button type="submit" class="btn-primary" style="padding: 1rem 3rem;">{{ __('Save Changes') }}</button>

            @if (session('status') === 'profile-updated')
                <p style="font-size: 0.875rem; color: var(--success);" class="animate-fade">{{ __('Saved successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
