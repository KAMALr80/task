<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Create Task</h1>
            <p style="color: var(--text-muted);">Assign a new task to a project and team member.</p>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn-primary" style="background: var(--glass); border: 1px solid var(--glass-border);">
            Back to List
        </a>
    </x-slot>

    <div class="glass-card" style="max-width: 800px; margin: 0 auto;">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div style="grid-column: span 2; margin-bottom: 0.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Task Title</label>
                    <input type="text" name="title" required style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;">
                </div>

                <div style="grid-column: span 2; margin-bottom: 0.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Description</label>
                    <textarea name="description" rows="3" style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;"></textarea>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Project</label>
                    <select name="project_id" required style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;">
                        @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Assigned To</label>
                    <select name="assigned_to" style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;">
                        <option value="">Unassigned</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Due Date</label>
                    <input type="date" name="due_date" required style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Priority</label>
                    <select name="priority" required style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.875rem;">Status</label>
                    <select name="status" required style="width: 100%; padding: 1rem; background: var(--glass); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: var(--text-color); outline: none;">
                        <option value="pending">Pending</option>
                        <option value="in-progress">In Progress</option>
                        <option value="submitted">Submitted</option>
                        <option value="on-hold">On Hold</option>
                        <option value="completed">Completed</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; margin-top: 2rem;">
                Create Task
            </button>
        </form>
    </div>
</x-app-layout>
