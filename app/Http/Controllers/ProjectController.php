<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['manager'])->withCount('tasks')->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'required|exists:users,id',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['tasks.assignee', 'manager']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'manager_id' => 'required|exists:users,id',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
