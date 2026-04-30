<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['project', 'assignee'])->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed,overdue',
            'priority' => 'required|in:low,medium,high',
        ]);

        $data = $request->all();
        $data['creator_id'] = Auth::id();
        $task = Task::create($data);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'task',
            'activity' => 'created',
            'description' => "Created a new task: {$task->title}",
            'subject_id' => $task->id
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load(['project', 'assignee']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        if ($task->creator_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to edit this task.');
        }

        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->creator_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to update this task.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed,overdue',
            'priority' => 'required|in:low,medium,high',
        ]);

        $oldStatus = $task->status;
        $task->update($request->all());

        $activityDesc = "Updated task: {$task->title}";
        if ($oldStatus !== $task->status) {
            $activityDesc = "Changed status of '{$task->title}' to " . ucfirst($task->status);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'task',
            'activity' => $oldStatus !== $task->status ? 'status_changed' : 'updated',
            'description' => $activityDesc,
            'subject_id' => $task->id
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        if ($task->creator_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to delete this task.');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function kanban()
    {
        $tasks = Task::with(['project', 'assignee'])->get();
        $pending = $tasks->where('status', 'pending');
        $in_progress = $tasks->where('status', 'in-progress');
        $completed = $tasks->where('status', 'completed');

        return view('tasks.kanban', compact('pending', 'in_progress', 'completed'));
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $oldStatus = $task->status;
        $task->update(['status' => $request->status]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'task',
            'activity' => 'status_changed',
            'description' => "Moved '{$task->title}' from " . ucfirst($oldStatus) . " to " . ucfirst($task->status),
            'subject_id' => $task->id
        ]);

        return response()->json(['success' => true]);
    }

    public function startTimer(Task $task)
    {
        if ($task->timer_started_at) {
            return response()->json(['success' => false, 'message' => 'Timer already running']);
        }

        $task->update(['timer_started_at' => now()]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'task',
            'activity' => 'timer_started',
            'description' => "Started timer for task: {$task->title}",
            'subject_id' => $task->id
        ]);

        return response()->json(['success' => true]);
    }

    public function stopTimer(Task $task)
    {
        if (!$task->timer_started_at) {
            return response()->json(['success' => false, 'message' => 'Timer not running']);
        }

        $seconds = now()->diffInSeconds($task->timer_started_at);
        $task->total_time_spent += $seconds;
        $task->timer_started_at = null;
        $task->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'task',
            'activity' => 'timer_stopped',
            'description' => "Stopped timer for task: {$task->title} (Worked for " . round($seconds/60, 1) . " mins)",
            'subject_id' => $task->id
        ]);

        return response()->json(['success' => true, 'total_time' => $task->total_time_spent]);
    }

    public function export()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $tasks = Task::with(['project', 'assignee'])->get();
        $fileName = 'tasks_report_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Title', 'Project', 'Assignee', 'Status', 'Priority', 'Time Spent (Mins)', 'Due Date'];

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                fputcsv($file, [
                    $task->id,
                    $task->title,
                    $task->project->name,
                    $task->assignee->name ?? 'Unassigned',
                    $task->status,
                    $task->priority,
                    round($task->total_time_spent / 60, 2),
                    $task->due_date
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
