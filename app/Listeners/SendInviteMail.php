<?php

namespace App\Listeners;

use App\Models\Invite;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class SendInviteMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;
        $invites=Invite::query()->where('email', $user->email)->get();
        foreach ($invites as $invite) {
            Mail::to($user->email)->send(new \App\Mail\Invite($user, $invite->invitor, $invite->vehicle, $invite->verification_token));
        }
    }
}
