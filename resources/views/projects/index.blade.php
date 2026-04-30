<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Projects</h1>
            <p style="color: var(--text-muted);">Manage your team projects and track their progress.</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('projects.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Project
        </a>
        @endif
    </x-slot>

    <div class="glass-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Manager</th>
                    <th>Tasks</th>
                    <th>Created At</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>
                        <div style="font-weight: 600; font-size: 1.1rem;">{{ $project->name }}</div>
                        <div style="font-size: 0.85rem; color: var(--text-muted); max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $project->description }}
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(45deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700;">
                                {{ strtoupper(substr($project->manager->name, 0, 1)) }}
                            </div>
                            {{ $project->manager->name }}
                        </div>
                    </td>
                    <td>
                        <span style="font-weight: 700; color: var(--primary);">{{ $project->tasks_count }}</span> tasks
                    </td>
                    <td style="color: var(--text-muted);">{{ $project->created_at->format('M d, Y') }}</td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                            <a href="{{ route('projects.show', $project) }}" class="btn-primary" style="padding: 0.5rem; background: var(--glass); border: 1px solid var(--glass-border);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('projects.edit', $project) }}" class="btn-primary" style="padding: 0.5rem; background: var(--glass); border: 1px solid var(--glass-border); color: var(--warning);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-primary" style="padding: 0.5rem; background: var(--glass); border: 1px solid var(--glass-border); color: var(--danger);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 5rem; color: var(--text-muted);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                        <p>No projects found. Create your first project to get started!</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
