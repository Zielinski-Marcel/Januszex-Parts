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
use Inertia\Inertia;
use Inertia\Response;

class InviteController extends Controller
{
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
        if($validated['email']==$invitor->email){
            abort(404, 'You cannot invite yourself.');
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
    public function update(String $token)
    {
        $invite=Invite::where('verification_token', $token)->first();
        if(!$invite){
            abort(404, 'Invitation not found.');
        }

        $user = User::query()->where('email', $invite->email)->firstOrFail();
        $vehicle = $invite->vehicle;


            $vehicle->users()->syncWithoutDetaching([
                $user->id => [
                    'role' => 'shared',
                    'status' => 'active',
                ],
        ]);
        $invite->delete();
        return redirect()->back()->with('status', 'Invite updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invite $invite)
    {
        if ($invite->invitor_id !== auth()->id() && $invite->email !== auth()->user()->email) {
            abort(403);
        }

        $invite->delete();
        return redirect()->back()->with('status', 'Invitation deleted successfully.');
    }
    public function index(): Response
    {
        $user = auth()->user();
        $invites = Invite::query()->where("invitor_id", $user->id)->with(["invitor", "vehicle"])->get();
        return Inertia::render('Invites', ["sentInvites" => $invites]);
    }
}
