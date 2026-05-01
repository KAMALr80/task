<x-app-layout>
    <div class="dashboard-wrapper">
        <x-sidebar />
        
        <main class="main-content">
            <div class="content-header">
                <div>
                    <h1 class="page-title">Admin Task Hub</h1>
                    <p class="page-subtitle">Verify, Approve, or Reject tasks across all projects</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('tasks.export') }}" class="btn-outline">
                        <svg style="width: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export Report
                    </a>
                </div>
            </div>

            <div class="glass-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Project</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Verification</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--text-color);">{{ $task->title }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">Due: {{ $task->due_date->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: var(--primary);">
                                    {{ $task->project->name }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: white;">
                                        {{ substr($task->assignee->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span style="font-size: 0.875rem;">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $task->status }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    @if($task->status !== 'approved')
                                    <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; background: var(--success);">Approve</button>
                                    </form>
                                    @endif

                                    @if($task->status !== 'rejected')
                                    <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.75rem; border-color: var(--danger); color: var(--danger);">Reject</button>
                                    </form>
                                    @endif

                                    @if($task->status !== 'cancelled')
                                    <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.75rem;">Cancel</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</x-app-layout>
