<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Task Details</h1>
            <p style="color: var(--text-muted);">{{ $task->title }}</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('tasks.index') }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border);">Back</a>
            <a href="{{ route('tasks.edit', $task) }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border); color: var(--warning);">Edit</a>
        </div>
    </x-slot>

    <div style="max-width: 800px; margin: 0 auto;">
        <div class="glass-card" style="margin-bottom: 2rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
                <div>
                    <span class="badge badge-{{ $task->status }}" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                        {{ ucfirst($task->status) }}
                    </span>
                    <span style="margin-left: 1rem; color: var(--{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'success') }}); font-weight: 700; text-transform: uppercase; font-size: 0.85rem;">
                        {{ $task->priority }} Priority
                    </span>
                </div>
                
                <div x-data="{ 
                        running: {{ $task->timer_started_at ? 'true' : 'false' }},
                        seconds: {{ $task->timer_started_at ? now()->diffInSeconds($task->timer_started_at) : 0 }},
                        total: {{ $task->total_time_spent }},
                        interval: null,
                        formatTime(sec) {
                            const hrs = Math.floor(sec / 3600);
                            const mins = Math.floor((sec % 3600) / 60);
                            const s = sec % 60;
                            return `${hrs}h ${mins}m ${s}s`;
                        },
                        start() {
                            fetch('{{ route('tasks.startTimer', $task) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                            .then(() => { 
                                this.running = true;
                                this.interval = setInterval(() => this.seconds++, 1000);
                                window.dispatchEvent(new CustomEvent('notify', { detail: { message: 'Timer started!', type: 'success' } }));
                            });
                        },
                        stop() {
                            fetch('{{ route('tasks.stopTimer', $task) }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                            .then(res => res.json())
                            .then(data => {
                                this.running = false;
                                clearInterval(this.interval);
                                this.total = data.total_time;
                                this.seconds = 0;
                                window.dispatchEvent(new CustomEvent('notify', { detail: { message: 'Timer stopped and saved!', type: 'success' } }));
                            });
                        }
                    }" 
                    x-init="if(running) interval = setInterval(() => seconds++, 1000)"
                    style="text-align: right;">
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">Time Tracking</div>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="font-family: monospace; font-size: 1.1rem; font-weight: 800; color: var(--primary);" x-text="formatTime(total + seconds)"></div>
                        <button @click="running ? stop() : start()" :class="running ? 'btn-danger' : 'btn-success'" style="padding: 0.4rem 1rem; font-size: 0.8rem; border-radius: 10px; display: flex; align-items: center; gap: 0.4rem;">
                            <template x-if="!running">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            </template>
                            <template x-if="running">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect width="4" height="16" x="6" y="4" rx="1"/><rect width="4" height="16" x="14" y="4" rx="1"/></svg>
                            </template>
                            <span x-text="running ? 'Stop' : 'Start'"></span>
                        </button>
                    </div>
                </div>
            </div>

            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">{{ $task->title }}</h2>
            <div style="color: var(--text-muted); line-height: 1.8; margin-bottom: 2rem;">
                {{ $task->description ?: 'No description provided.' }}
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; border-top: 1px solid var(--glass-border); padding-top: 2rem;">
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">Project</div>
                    <a href="{{ route('projects.show', $task->project) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                        {{ $task->project->name }}
                    </a>
                </div>
                <div>
                    <div style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.5rem;">Assigned To</div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--glass); display: flex; align-items: center; justify-content: center; font-weight: 700;">
                            {{ strtoupper(substr($task->assignee->name ?? 'U', 0, 1)) }}
                        </div>
                        <span style="font-weight: 600;">{{ $task->assignee->name ?? 'Unassigned' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="glass-card" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Discussion</h3>
            
            <form action="{{ route('comments.store') }}" method="POST" style="margin-bottom: 2.5rem;">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <div style="position: relative;">
                    <textarea name="content" placeholder="Type your comment here..." style="width: 100%; min-height: 100px; padding: 1.25rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 1.25rem; color: var(--text-color); resize: none; margin-bottom: 1rem;" required></textarea>
                    <button type="submit" class="btn-primary" style="position: absolute; bottom: 2rem; right: 1rem; padding: 0.5rem 1.5rem;">Post</button>
                </div>
            </form>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @forelse($task->comments as $comment)
                <div style="display: flex; gap: 1rem; padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 1.25rem; border: 1px solid var(--glass-border);">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-weight: 800; color: white; flex-shrink: 0;">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.25rem;">
                            <span style="font-weight: 700; font-size: 0.9rem;">{{ $comment->user->name }}</span>
                            <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div style="font-size: 0.95rem; color: var(--text-color); line-height: 1.5;">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 2rem; color: var(--text-muted); font-size: 0.9rem;">No comments yet. Start the conversation!</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
