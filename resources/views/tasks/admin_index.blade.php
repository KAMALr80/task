@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<style>
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        background: var(--glass) !important;
        border: 1px solid var(--glass-border) !important;
        color: var(--text-color) !important;
        border-radius: 0.5rem;
        padding: 0.4rem 0.8rem;
    }
    .dataTables_info, .dataTables_paginate {
        margin-top: 1.5rem !important;
        color: var(--text-muted) !important;
        font-size: 0.85rem;
    }
    .paginate_button {
        border-radius: 0.5rem !important;
    }
    .custom-table {
        border: none !important;
        box-shadow: none !important;
    }
    .custom-table thead th {
        background: rgba(255,255,255,0.02) !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.75rem;
        border-bottom: 1px solid var(--glass-border) !important;
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
    }
    .custom-table td {
        border: none !important;
        border-bottom: 1px solid var(--glass-border) !important;
    }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
            <div>
                <h1 class="page-title" style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem;">Admin Task Hub</h1>
                <p class="page-subtitle" style="color: var(--text-muted); font-size: 1.1rem;">Elite verification center for all workspace activity</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('tasks.export') }}" class="btn-primary" style="background: var(--glass); border-color: var(--glass-border); color: var(--success); display: flex; align-items: center; gap: 0.75rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export Report
                </a>
            </div>
        </div>
    </x-slot>

    <div class="glass-card" style="padding: 2rem;">
        <table id="adminTasksTable" class="custom-table" style="width:100%">
            <thead>
                <tr>
                    <th>Task Details</th>
                    <th>Project</th>
                    <th>Team Member</th>
                    <th>Status</th>
                    <th style="text-align: right;">Verification Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>
                        <div style="font-weight: 700; color: var(--text-color); font-size: 1rem;">{{ $task->title }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.25rem;">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</div>
                    </td>
                    <td>
                        <span style="padding: 0.4rem 0.8rem; background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.1); border-radius: 2rem; font-size: 0.8rem; font-weight: 600;">
                            {{ $task->project->name }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800; color: white;">
                                {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                            </div>
                            <span style="font-weight: 600; font-size: 0.9rem;">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $task->status }}" style="padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 700; text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.05em;">
                            {{ ucfirst($task->status) }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                            @if($task->status !== 'approved')
                            <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">Approve</button>
                            </form>
                            @endif
                            
                            @if($task->status !== 'rejected')
                            <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2);">Reject</button>
                            </form>
                            @endif

                            @if($task->status !== 'cancelled' && $task->status !== 'approved' && $task->status !== 'rejected')
                            <form action="{{ route('admin.tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.75rem; background: rgba(100, 116, 139, 0.1); color: #64748b; border: 1px solid rgba(100, 116, 139, 0.2);">Cancel</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#adminTasksTable').DataTable({
                "pageLength": 10,
                "order": [[0, "desc"]],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search tasks..."
                },
                "drawCallback": function() {
                    $('.dataTables_paginate .paginate_button').addClass('btn-primary').css({
                        'margin': '0 2px',
                        'padding': '5px 10px',
                        'font-size': '12px'
                    });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
