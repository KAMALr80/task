<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Team Members</h1>
            <p style="color: var(--text-muted);">Manage your organization's team members and roles.</p>
        </div>
    </x-slot>

    <div class="glass-card animate-fade">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Projects</th>
                    <th>Tasks</th>
                    <th>Joined At</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--glass); display: flex; align-items: center; justify-content: center; font-weight: 800; border: 1px solid var(--glass-border); color: var(--primary);">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div style="font-weight: 600;">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td style="color: var(--text-muted);">{{ $user->email }}</td>
                    <td>
                        <span class="badge" style="background: {{ $user->role === 'admin' ? 'rgba(99, 102, 241, 0.1)' : 'rgba(148, 163, 184, 0.1)' }}; color: {{ $user->role === 'admin' ? 'var(--primary)' : 'var(--text-muted)' }}; border: 1px solid {{ $user->role === 'admin' ? 'rgba(99, 102, 241, 0.2)' : 'rgba(148, 163, 184, 0.2)' }};">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="font-weight: 600;">{{ $user->projects_count }}</td>
                    <td style="font-weight: 600;">{{ $user->tasks_count }}</td>
                    <td style="color: var(--text-muted);">{{ $user->created_at->format('M d, Y') }}</td>
                    <td style="text-align: right;">
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this member?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary" style="padding: 0.5rem; background: var(--glass); border: 1px solid var(--glass-border); color: var(--danger);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                            </button>
                        </form>
                        @else
                        <span style="color: var(--text-muted); font-size: 0.75rem;">(You)</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
