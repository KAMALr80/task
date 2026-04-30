<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">{{ $project->name }}</h1>
            <p style="color: var(--text-muted);">Manager: {{ $project->manager->name }} | Created: {{ $project->created_at->format('M d, Y') }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('projects.index') }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border);">Back</a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('projects.edit', $project) }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border); color: var(--warning);">Edit</a>
            @endif
        </div>
    </x-slot>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
        <div>
            <div class="glass-card" style="margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; font-weight: 700;">Description</h3>
                <p style="color: var(--text-muted); line-height: 1.6;">{{ $project->description ?: 'No description provided.' }}</p>
            </div>

            <div class="glass-card">
                <h3 style="margin-bottom: 2rem; font-weight: 700;">Project Tasks</h3>
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Assignee</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($project->tasks as $task)
                        <tr>
                            <td style="font-weight: 600;">{{ $task->title }}</td>
                            <td>{{ $task->assignee->name ?? 'Unassigned' }}</td>
                            <td>
                                <span class="badge badge-{{ $task->status }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 2rem; color: var(--text-muted);">No tasks in this project.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="glass-card">
                <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Project Stats</h3>
                <div style="margin-bottom: 1rem;">
                    <div style="color: var(--text-muted); font-size: 0.85rem;">Total Tasks</div>
                    <div style="font-size: 1.5rem; font-weight: 800;">{{ $project->tasks->count() }}</div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <div style="color: var(--text-muted); font-size: 0.85rem;">Completed</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--success);">{{ $project->tasks->where('status', 'completed')->count() }}</div>
                </div>
                <div style="margin-bottom: 1rem;">
                    <div style="color: var(--text-muted); font-size: 0.85rem;">Pending</div>
                    <div style="font-size: 1.5rem; font-weight: 800; color: var(--warning);">{{ $project->tasks->where('status', 'pending')->count() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
