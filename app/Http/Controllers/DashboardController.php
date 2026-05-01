<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $team_workload = null;
        
        if ($user->isAdmin()) {
            $stats = [
                'total_projects' => Project::count(),
                'total_tasks' => Task::count(),
                'total_users' => \App\Models\User::count(),
                'completed_tasks' => Task::where('status', 'approved')->count(),
                'pending_tasks' => Task::whereNotIn('status', ['approved', 'completed'])->count(),
                'overdue_tasks' => Task::where('status', '!=', 'approved')
                                      ->where('due_date', '<', now()->toDateString())
                                      ->count(),
            ];
            $recent_tasks = Task::with(['project', 'assignee'])->latest()->take(10)->get();
            $team_workload = \App\Models\User::withCount('tasks')->get();
        } else {
            $stats = [
                'total_projects' => Project::whereHas('tasks', function($q) use ($user) {
                    $q->where('assigned_to', $user->id);
                })->count(),
                'total_tasks' => Task::where('assigned_to', $user->id)->count(),
                'completed_tasks' => Task::where('assigned_to', $user->id)->where('status', 'approved')->count(),
                'pending_tasks' => Task::where('assigned_to', $user->id)->whereNotIn('status', ['approved', 'completed'])->count(),
                'overdue_tasks' => Task::where('assigned_to', $user->id)
                                      ->where('status', '!=', 'approved')
                                      ->where('due_date', '<', now()->toDateString())
                                      ->count(),
            ];
            $recent_tasks = Task::where('assigned_to', $user->id)->with(['project'])->latest()->take(5)->get();
        }

        $recent_activities = \App\Models\ActivityLog::with('user')->latest()->take(8)->get();

        // Chart Data: Task Distribution
        $chart_data = [
            'labels' => ['Pending', 'In Progress', 'Completed', 'Overdue'],
            'counts' => [
                Task::where('status', 'pending')->count(),
                Task::where('status', 'in-progress')->count(),
                Task::where('status', 'completed')->count(),
                Task::where('status', 'overdue')->count(),
            ]
        ];

        return view('dashboard', compact('stats', 'recent_tasks', 'team_workload', 'recent_activities', 'chart_data'));
    }
}
