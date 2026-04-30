<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Only admins can see all team members
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::withCount(['projects', 'tasks'])->latest()->get();
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'admin' || $user->id === Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User removed successfully.');
    }
}
