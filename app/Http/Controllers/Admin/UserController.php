<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class UserController
{
    public function userLogs(User $user)
    {
        $logs = Activity::where('causer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render(
            'Admin/Logs',
            ["logs" => $logs]
        );
    }
    public function index()
    {
        activity()
            ->causedBy(auth()->user())
            ->log('Accessed the user list.');
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        activity()
            ->causedBy(auth()->user())
            ->log('Accessed the create user page.');
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:user,admin',
        ]);

        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ])
            ->log('Created a new user.');
        return redirect()->route('admin.users.index')->with('status', 'User created successfully.');
    }

    public function edit(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Accessed the edit user page.');
        return Inertia::render(
            'Admin/EditUser',
            ["user" => $user]

        );
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ])
            ->log('Updated user information.');
        return redirect("/admin")->with('status', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->withProperties([
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ])
            ->log('Deleted a user.');
        $user->delete();
        return redirect("/admin")->with('status', 'User deleted successfully.');
    }
}
