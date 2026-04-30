<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'content' => 'required|string|max:1000',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'task_id' => $request->task_id,
            'content' => $request->content,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'task',
            'activity' => 'commented',
            'description' => "Commented on task '{$comment->task->title}'",
            'subject_id' => $comment->task_id
        ]);

        return back()->with('success', 'Comment added successfully.');
    }
}
