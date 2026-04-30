<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Create Project</h1>
            <p style="color: var(--text-muted);">Define a new project and assign a manager.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border);">
            Back to List
        </a>
    </x-slot>

    <div class="glass-card" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Project Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 1rem; background: var(--dark); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: white; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--glass-border)'">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 1rem; background: var(--dark); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: white; outline: none; transition: 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--glass-border)'"></textarea>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Project Manager</label>
                <select name="manager_id" required style="width: 100%; padding: 1rem; background: var(--dark); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: white; outline: none; transition: 0.2s;">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem;">
                Create Project
            </button>
        </form>
    </div>
</x-app-layout>
