<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-color);">
                {{ auth()->user()->isAdmin() ? 'Admin Insights' : 'My Dashboard' }}
            </h1>
            <p style="color: var(--text-muted); font-size: 1.1rem;">Welcome back, {{ auth()->user()->name }}! Here's what's happening.</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('users.index') }}" class="btn-primary" style="background: var(--glass); border-color: var(--glass-border);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Team
            </a>
            @endif
            <div style="display: flex; gap: 1rem;">
                @if(auth()->user()->isAdmin())
                <a href="{{ route('tasks.export') }}" class="btn-primary" style="background: var(--glass); border-color: var(--glass-border); color: var(--success);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Export Reports
                </a>
                @endif
                <a href="{{ route('tasks.create') }}" class="btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    New Task
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Global Stats -->
    <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 3rem;">
        <div class="glass-card animate-fade stagger-1">
            <div class="stat-label">{{ auth()->user()->isAdmin() ? 'Total Projects' : 'Active Projects' }}</div>
            <div class="stat-val" style="color: var(--primary);">{{ $stats['total_projects'] }}</div>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="glass-card animate-fade stagger-2">
            <div class="stat-label">Total Team</div>
            <div class="stat-val" style="color: #8b5cf6;">{{ $stats['total_users'] }}</div>
        </div>
        @endif
        <div class="glass-card animate-fade stagger-3">
            <div class="stat-label">Pending Tasks</div>
            <div class="stat-val" style="color: var(--warning);">{{ $stats['pending_tasks'] }}</div>
        </div>
        <div class="glass-card animate-fade stagger-1">
            <div class="stat-label">Completed</div>
            <div class="stat-val" style="color: var(--success);">{{ $stats['completed_tasks'] }}</div>
        </div>
        <div class="glass-card animate-fade stagger-2">
            <div class="stat-label">Overdue</div>
            <div class="stat-val" style="color: var(--danger);">{{ $stats['overdue_tasks'] }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: {{ auth()->user()->isAdmin() ? '2.5fr 1fr' : '1fr' }}; gap: 2.5rem;">
        <!-- Primary Activity Section -->
        <div class="glass-card animate-fade" style="padding: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.5rem; font-weight: 700;">{{ auth()->user()->isAdmin() ? 'Recent Global Activity' : 'My Recent Tasks' }}</h3>
                <a href="{{ route('tasks.index') }}" style="color: var(--primary); text-decoration: none; font-size: 0.9rem; font-weight: 600;">View All Activity</a>
            </div>

            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Project</th>
                        <th>Status</th>
                        @if(auth()->user()->isAdmin()) <th>Assignee</th> @endif
                        <th>Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_tasks as $task)
                    <tr>
                        <td style="font-weight: 700; color: var(--text-color);">{{ $task->title }}</td>
                        <td style="color: var(--text-muted);">{{ $task->project->name }}</td>
                        <td>
                            <span class="badge badge-{{ $task->status }}">
                                {{ ucfirst($task->status) }}
                            </span>
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 28px; height: 28px; border-radius: 8px; background: var(--glass); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; border: 1px solid var(--glass-border); color: var(--primary); font-weight: 700;">
                                    {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                                </div>
                                <span style="font-size: 0.9rem;">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                            </div>
                        </td>
                        @endif
                        <td style="color: var(--text-muted); font-size: 0.9rem;">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? '5' : '4' }}" style="text-align: center; padding: 4rem; color: var(--text-muted);">No activity found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Admin Sidebar Section -->
        @if(auth()->user()->isAdmin() && isset($team_workload))
        <div class="glass-card animate-fade stagger-3" style="padding: 2.5rem;">
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">Team Workload</h3>
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($team_workload as $member)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 1.25rem; border: 1px solid var(--glass-border); transition: 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='rgba(255,255,255,0.02)'">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-weight: 800; color: white; border: 1px solid var(--glass-border);">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size: 0.95rem; font-weight: 700;">{{ $member->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">{{ $member->role }}</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 1.25rem; font-weight: 800; color: white;">{{ $member->tasks_count }}</div>
                        <div style="font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase;">Tasks</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <a href="{{ route('users.index') }}" class="btn-primary" style="width: 100%; margin-top: 2rem; background: var(--glass); border-color: var(--glass-border); justify-content: center;">
                Manage Team
            </a>
        </div>
        @endif
    </div>

    <!-- Real-time Activity Feed -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2.5rem; margin-top: 2.5rem;">
        <div class="glass-card animate-fade stagger-2" style="padding: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.5rem; font-weight: 700;">Real-time Activity Feed</h3>
                <span style="padding: 0.5rem 1rem; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; animation: pulse 2s infinite;"></span>
                    LIVE UPDATES
                </span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @forelse($recent_activities as $activity)
                <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1.25rem; background: var(--glass); border-radius: 1.25rem; border: 1px solid var(--glass-border); transition: 0.3s;">
                    <div style="width: 45px; height: 45px; border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-weight: 800; color: white; flex-shrink: 0;">
                        {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                    </div>
                    <div style="flex-grow: 1;">
                        <div style="font-weight: 700; font-size: 1rem;">{{ $activity->description }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem; margin-top: 0.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $activity->user->name }}
                            <span style="opacity: 0.5;">&bull;</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div style="padding: 0.5rem 1rem; background: rgba(99, 102, 241, 0.1); color: var(--primary); border-radius: 12px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                        {{ $activity->type }}
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem; color: var(--text-muted);">No activities logged yet.</div>
                @endforelse
            </div>
        </div>

        <div class="glass-card animate-fade stagger-3" style="padding: 2.5rem;">
            <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">Analytics</h3>
            <div style="height: 250px; display: flex; align-items: center; justify-content: center;">
                <canvas id="taskChart"></canvas>
            </div>
            <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--text-muted); font-size: 0.9rem;">Team Efficiency</span>
                    <span style="font-weight: 700; color: var(--success);">{{ $stats['total_tasks'] > 0 ? round(($stats['completed_tasks'] / $stats['total_tasks']) * 100) : 0 }}%</span>
                </div>
                <div style="width: 100%; height: 6px; background: var(--glass); border-radius: 3px; overflow: hidden;">
                    <div style="width: {{ $stats['total_tasks'] > 0 ? ($stats['completed_tasks'] / $stats['total_tasks']) * 100 : 0 }}%; height: 100%; background: var(--success);"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('taskChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($chart_data['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($chart_data['counts']) !!},
                        backgroundColor: [
                            'rgba(245, 158, 11, 0.6)',
                            'rgba(99, 102, 241, 0.6)',
                            'rgba(16, 185, 129, 0.6)',
                            'rgba(239, 68, 68, 0.6)'
                        ],
                        borderColor: [
                            '#f59e0b',
                            '#6366f1',
                            '#10b981',
                            '#ef4444'
                        ],
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: getComputedStyle(document.documentElement).getPropertyValue('--text-color').trim(),
                                padding: 20,
                                font: { size: 12, weight: '600' }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
