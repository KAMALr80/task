<section>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>

    <button type="button" class="btn-primary" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem 2.5rem;" onclick="document.getElementById('delete-modal').style.display='flex'">
        {{ __('DELETE ACCOUNT') }}
    </button>

    <!-- Simple Glass Modal -->
    <div id="delete-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(8px); z-index: 1000; align-items: center; justify-content: center;">
        <div class="glass-card" style="max-width: 500px; width: 90%; padding: 3rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: white; margin-bottom: 1rem;">Are you sure?</h2>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Once your account is deleted, all data will be gone forever. Please enter your password to confirm.</p>
            
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="glass-input-group">
                    <label for="password" class="glass-label">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" class="glass-input" placeholder="{{ __('Password') }}" required />
                    @error('password', 'userDeletion') <div class="input-error">{{ $message }}</div> @enderror
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                    <button type="button" class="btn-primary" style="background: var(--glass); border-color: var(--glass-border);" onclick="document.getElementById('delete-modal').style.display='none'">CANCEL</button>
                    <button type="submit" class="btn-primary" style="background: #ef4444; border: none;">DELETE PERMANENTLY</button>
                </div>
            </form>
        </div>
    </div>
</section>
