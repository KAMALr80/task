<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div>
                <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-color);">
                    Visual Kanban Board
                </h1>
                <p style="color: var(--text-muted); font-size: 1.1rem;">Drag and drop tasks to update their status instantly.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('tasks.index') }}" class="btn-primary" style="background: var(--glass); border-color: var(--glass-border);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    List View
                </a>
                <a href="{{ route('tasks.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Task
                </a>
            </div>
        </div>
    </x-slot>

    <div class="kanban-board" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; min-height: 70vh;">
        <!-- Pending Column -->
        <div class="kanban-column" data-status="pending">
            <div class="column-header">
                <span class="column-dot" style="background: var(--warning);"></span>
                Pending
                <span class="column-count">{{ $pending->count() }}</span>
            </div>
            <div class="kanban-list" id="pending-list">
                @foreach($pending as $task)
                <div class="kanban-card glass-card animate-fade" data-id="{{ $task->id }}">
                    <div class="card-priority {{ $task->priority }}"></div>
                    <div class="card-project">{{ $task->project->name }}</div>
                    <div class="card-title">{{ $task->title }}</div>
                    <div class="card-meta">
                        <div class="card-assignee">
                            {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="card-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- In Progress Column -->
        <div class="kanban-column" data-status="in-progress">
            <div class="column-header">
                <span class="column-dot" style="background: var(--primary);"></span>
                In Progress
                <span class="column-count">{{ $in_progress->count() }}</span>
            </div>
            <div class="kanban-list" id="in-progress-list">
                @foreach($in_progress as $task)
                <div class="kanban-card glass-card animate-fade" data-id="{{ $task->id }}">
                    <div class="card-priority {{ $task->priority }}"></div>
                    <div class="card-project">{{ $task->project->name }}</div>
                    <div class="card-title">{{ $task->title }}</div>
                    <div class="card-meta">
                        <div class="card-assignee">
                            {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="card-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Completed Column -->
        <div class="kanban-column" data-status="completed">
            <div class="column-header">
                <span class="column-dot" style="background: var(--success);"></span>
                Completed
                <span class="column-count">{{ $completed->count() }}</span>
            </div>
            <div class="kanban-list" id="completed-list">
                @foreach($completed as $task)
                <div class="kanban-card glass-card animate-fade" data-id="{{ $task->id }}">
                    <div class="card-priority {{ $task->priority }}"></div>
                    <div class="card-project">{{ $task->project->name }}</div>
                    <div class="card-title">{{ $task->title }}</div>
                    <div class="card-meta">
                        <div class="card-assignee">
                            {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                        </div>
                        <div class="card-date">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lists = ['pending-list', 'in-progress-list', 'completed-list'];
            
            lists.forEach(id => {
                new Sortable(document.getElementById(id), {
                    group: 'kanban',
                    animation: 150,
                    ghostClass: 'kanban-ghost',
                    onEnd: function(evt) {
                        const taskId = evt.item.getAttribute('data-id');
                        const newStatus = evt.to.parentElement.getAttribute('data-status');
                        
                        // Update status via AJAX
                        fetch(`/tasks/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.dispatchEvent(new CustomEvent('notify', { 
                                    detail: { message: 'Task status updated!', type: 'success' } 
                                }));
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endpush

    <style>
        .column-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 800;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            color: var(--text-color);
        }
        .column-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .column-count {
            margin-left: auto;
            background: var(--glass);
            padding: 0.25rem 0.75rem;
            border-radius: 10px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        .kanban-list {
            min-height: 500px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .kanban-card {
            padding: 1.25rem !important;
            cursor: grab;
            position: relative;
            overflow: hidden;
        }
        .kanban-card:active { cursor: grabbing; }
        .card-priority {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
        }
        .card-priority.high { background: var(--danger); }
        .card-priority.medium { background: var(--warning); }
        .card-priority.low { background: var(--success); }
        
        .card-project {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .card-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-assignee {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--glass);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--primary);
            border: 1px solid var(--glass-border);
        }
        .card-date {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            color: var(--text-muted);
        }
        .kanban-ghost {
            opacity: 0.4;
            background: var(--primary) !important;
        }
    </style>
</x-app-layout>
