<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show($username)
    {

    }


    public function edit(Request $request): Response
    {
        $user = $request->user();
        $ownedVehicles = $user->vehicles()->wherePivot('status', 'active')->wherePivot('role', 'owner')->get();
        $sharedVehicles = $user->vehicles()->wherePivot('status', 'active')->wherePivot('role', 'shared')->get();
        activity()
            ->causedBy($user)
            ->withProperties(['action' => 'Editing profile'])
            ->log('User entered profile edit page');
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'vehicles' => [
                'owned' => $ownedVehicles,
                'shared' => $sharedVehicles,
            ],
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        $user = $request->user();
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
        activity()
            ->causedBy($user)
            ->withProperties([
                'changes' => $request->validated()
            ])
            ->log('User updated profile information');
        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        activity()
            ->causedBy($user)
            ->withProperties(['action' => 'Deleted account'])
            ->log('User deleted their account');
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
