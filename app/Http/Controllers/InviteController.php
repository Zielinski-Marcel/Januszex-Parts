<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\StoreInviteRequest;
use App\Http\Requests\Invite\UpdateInviteRequest;
use App\Mail\InviteIfNoAccount;
use App\Models\Invite;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInviteRequest $request)
    {
        $validated = $request->validated();
        $invitor = auth()->user();

        $vehicle = Vehicle::find($validated['vehicle_id']);
        if (!$vehicle || $vehicle->owner_id !== $invitor->id) {
           abort(404, 'Vehicle not found or unauthorized.');
        }

        $token = (string) Str::uuid();

        Invite::create([
            'vehicle_id' => $vehicle->id,
            'email' => $validated['email'],
            'invitor_id' => $invitor->id,
            'status' => 'pending',
            'verification_token' => $token,

        ]);

        $user = User::where('email', $validated['email'])->first();
        if ($user) {
            Mail::to($validated['email'])->send(new \App\Mail\Invite($user, $invitor, $vehicle, $token));
        }else{
            Mail::to($validated['email'])->send(new InviteIfNoAccount($validated['email'], $invitor, $vehicle));
        }
        return redirect()->back()->with('status', 'Invitation sent successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Invite $invite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invite $invite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInviteRequest $request, String $token)
    {
        $validated = $request->validated();
        $invite=Invite::where('verification_token', $token)->first();
        if(!$invite){
            abort(404, 'Invitation not found.');
        }
        $invite->update([
            'status' => $validated['status']
        ]);

        $user = User::query()->where('email', $invite->email)->firstOrFail();
        $vehicle = $invite->vehicle;

        if ($validated['status'] === 'accepted') {
            $vehicle->users()->syncWithoutDetaching([
                $user->id => [
                    'role' => 'shared',
                    'status' => 'active',
                ],
            ]);
        }
        $invite->delete();
        return redirect('/dashboard')->with('status', 'Invite updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invite $invite)
    {
        if ($invite->invitor_id !== auth()->id()) {
            abort(403);
        }

        $invite->delete();
        return redirect()->back()->with('status', 'Invitation deleted successfully.');
    }
}
