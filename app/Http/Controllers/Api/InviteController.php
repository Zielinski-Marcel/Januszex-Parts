<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invite\StoreInviteRequest;
use App\Http\Requests\Invite\UpdateInviteRequest;
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
    public function store(StoreInviteRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $invitor = auth()->user();
        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }


        $vehicle = Vehicle::find($validated['vehicle_id']);
        if (!$vehicle || $vehicle->owner_id !== $invitor->id) {
            return response()->json(['message' => 'Vehicle not found or unauthorized.'], 404);
        }

        $token = (string) Str::uuid();

        Invite::create([
            'invitee_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'email' => $validated['email'],
            'invitor_id' => $invitor->id,
            'status' => 'pending',
            'verification_token' => $token,

        ]);
        Mail::to($validated['email'])->send(new \App\Mail\Invite($user, $invitor, $vehicle, $token));
        return response()->json(['message' => 'Invitation sent successfully.' ]);
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
            return response()->json(['message' => 'Invitation not found.'], 404);
        }
        $invite->update([
            'status' => $validated['status']
        ]);

        $user = $invite->user;
        $vehicle = $invite->vehicle;

        if ($validated['status'] === 'accepted') {
            $vehicle->users()->syncWithoutDetaching([
                $user->id => [
                    'role' => 'shared',
                    'status' => 'active',
                ],
            ]);
        }

        return response()->json([
            'message' => 'Invite updated successfully.',
            'invite' => $invite,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invite $invite)
    {
        if ($invite->invitor_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $invite->delete();
        return response()->json(['message' => 'Invitation deleted successfully.']);
    }
}
