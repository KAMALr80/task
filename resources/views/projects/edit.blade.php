<x-app-layout>
    <div style="width: 100%;">
        <div class="glass-card animate-fade" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 3.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 2rem;">
                <div>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; background: linear-gradient(to right, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Edit Project</h2>
                    <p style="color: var(--text-muted); font-size: 1.1rem;">Modify project details and management</p>
                </div>
                <a href="{{ route('projects.index') }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border); padding: 0.75rem 1.5rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 0.5rem;"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to List
                </a>
            </div>

            <form action="{{ route('projects.update', $project) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; margin-bottom: 2.5rem;">
                    <div>
                        <label for="name" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Project Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required style="width: 100%; padding: 1rem;">
                        @error('name') <div class="input-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="manager_id" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Project Manager</label>
                        <select name="manager_id" id="manager_id" required style="width: 100%; padding: 1rem;">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $project->manager_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 3rem;">
                    <label for="description" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Description</label>
                    <textarea name="description" id="description" rows="5" style="width: 100%; padding: 1rem; border-radius: 1rem;">{{ old('description', $project->description) }}</textarea>
                </div>

                <div style="display: flex; gap: 1.5rem; border-top: 1px solid var(--glass-border); padding-top: 2.5rem;">
                    <button type="submit" class="btn-primary" style="padding: 1.25rem 4rem; font-size: 1.1rem; font-weight: 700; letter-spacing: 0.05em;">UPDATE PROJECT</button>
                    <a href="{{ route('projects.index') }}" class="btn-primary" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 1.25rem 3rem;">CANCEL</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
