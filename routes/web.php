<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('projects', ProjectController::class);
    
    Route::get('/tasks/kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
    Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::post('/tasks/{task}/start-timer', [TaskController::class, 'startTimer'])->name('tasks.startTimer');
    Route::post('/tasks/{task}/stop-timer', [TaskController::class, 'stopTimer'])->name('tasks.stopTimer');
    Route::resource('tasks', TaskController::class);
    
    Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    
    Route::resource('users', UserController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';
