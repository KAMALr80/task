<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Tasks</h1>
            <p style="color: var(--text-muted);">View and manage all team tasks across projects.</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Task
        </a>
    </x-slot>

    <div class="glass-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Project</th>
                    <th>Assignee</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr>
                    <td style="font-weight: 600;">{{ $task->title }}</td>
                    <td style="color: var(--text-muted);">{{ $task->project->name }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--glass); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; border: 1px solid var(--glass-border);">
                                {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                            </div>
                            {{ $task->assignee->name ?? 'Unassigned' }}
                        </div>
                    </td>
                    <td>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: {{ $task->priority === 'high' ? 'var(--danger)' : ($task->priority === 'medium' ? 'var(--warning)' : 'var(--success)') }}">
                            {{ $task->priority }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $task->status }}">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>
                    <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; align-items: center;">
                            @if($task->status !== 'approved')
                                @if($task->creator_id === Auth::id() || Auth::user()->role === 'admin')
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn-primary" style="padding: 0.5rem; background: var(--glass); border: 1px solid var(--glass-border); color: var(--warning);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                    </a>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem; background: var(--glass); border: 1px solid var(--glass-border); color: var(--danger);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                        </button>
                                    </form>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.75rem;">View Only</span>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 5rem; color: var(--text-muted);">No tasks found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
