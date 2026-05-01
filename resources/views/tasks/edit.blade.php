<x-app-layout>
    <div style="width: 100%;">
        <div class="glass-card animate-fade" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 3.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 2rem;">
                <div>
                    <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-color);">Edit Task</h2>
                    <p style="color: var(--text-muted); font-size: 1.1rem;">Update task details and assignments</p>
                </div>
                <a href="{{ route('tasks.index') }}" class="btn-outline" style="padding: 0.75rem 1.5rem; border-radius: 1rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; border: 1px solid var(--glass-border); color: var(--text-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to List
                </a>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2.5rem; margin-bottom: 2.5rem;">
                    <div style="grid-column: span 2;">
                        <label for="title" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Task Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" required style="width: 100%; font-size: 1.1rem; padding: 1rem;">
                        @error('title') <div class="input-error">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="project_id" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Project</label>
                        <select name="project_id" id="project_id" required style="width: 100%; padding: 1rem;">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="assigned_to" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Assignee</label>
                        <select name="assigned_to" id="assigned_to" style="width: 100%; padding: 1rem;">
                            <option value="">Unassigned</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="due_date" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', \Carbon\Carbon::parse($task->due_date)->format('Y-m-d')) }}" required style="width: 100%; padding: 1rem;">
                    </div>

                    <div>
                        <label for="priority" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Priority</label>
                        <select name="priority" id="priority" required style="width: 100%; padding: 1rem;">
                            <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Status</label>
                        <select name="status" id="status" required style="width: 100%; padding: 1rem;">
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in-progress" {{ $task->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="submitted" {{ $task->status == 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="on-hold" {{ $task->status == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="overdue" {{ $task->status == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 3rem;">
                    <label for="description" style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem; display: block;">Description</label>
                    <textarea name="description" id="description" rows="5" style="width: 100%; padding: 1rem; border-radius: 1rem;">{{ old('description', $task->description) }}</textarea>
                </div>

                <div style="display: flex; gap: 1.5rem; border-top: 1px solid var(--glass-border); padding-top: 2.5rem;">
                    <button type="submit" class="btn-primary" style="padding: 1.25rem 4rem; font-size: 1.1rem; font-weight: 700; letter-spacing: 0.05em;">UPDATE TASK</button>
                    <a href="{{ route('tasks.index') }}" class="btn-primary" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 1.25rem 3rem;">CANCEL</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
