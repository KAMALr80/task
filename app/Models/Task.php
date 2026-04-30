<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'project_id', 
        'assigned_to', 
        'due_date', 
        'status', 
        'priority',
        'creator_id'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
