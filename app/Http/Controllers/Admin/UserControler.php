<?php

namespace App\Http\Controllers\Admin;

class UserControler
{
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
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        activity()
            ->causedBy(auth()->user())
            ->performedOn($user)
            ->log('Accessed the edit user page.');

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:user,admin',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
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
            ->log('Updated user information.');
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
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
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
