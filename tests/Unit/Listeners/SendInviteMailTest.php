<?php

namespace Tests\Unit\Listeners;

use App\Listeners\SendInviteMail;
use App\Mail\Invite;
use App\Models\Invite as InviteModel;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SendInviteMailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_handle_sends_invite_emails(): void
    {
        // Arrange
        Mail::fake();

        // Create an inviter and a user (invitee)
        $invitor = User::factory()->create();
        $invitee = User::factory()->unverified()->create(); // Unverified initially

        // Create vehicles
        $vehicle1 = \App\Models\Vehicle::factory()->create();
        $vehicle2 = \App\Models\Vehicle::factory()->create();

        // Create invites for the invitee
        $invite1 = InviteModel::create([
            'invitor_id' => $invitor->id,
            'email' => $invitee->email,
            'vehicle_id' => $vehicle1->id, // Use the created vehicle
            'status' => 'pending',
            'verification_token' => 'some-random-token',
        ]);

        $invite2 = InviteModel::create([
            'invitor_id' => $invitor->id,
            'email' => $invitee->email,
            'vehicle_id' => $vehicle2->id, // Use the created vehicle
            'status' => 'pending',
            'verification_token' => 'another-random-token',
        ]);

        // Act: Simulate the Verified event
        $event = new Verified($invitee);
        $listener = new SendInviteMail();
        $listener->handle($event);

        // Assert: Check that emails were sent for both invites
        Mail::assertSent(Invite::class, 2);

        // Assert email details
        Mail::assertSent(Invite::class, function ($mail) use ($invitee, $invitor, $invite1) {
            return $mail->hasTo($invitee->email) &&
                $mail->user->is($invitee) &&
                $mail->invitor->is($invitor) &&
                $mail->vehicle->id === $invite1->vehicle_id &&
                $mail->token === $invite1->verification_token; // Change to $token here
        });

        Mail::assertSent(Invite::class, function ($mail) use ($invitee, $invitor, $invite2) {
            return $mail->hasTo($invitee->email) &&
                $mail->user->is($invitee) &&
                $mail->invitor->is($invitor) &&
                $mail->vehicle->id === $invite2->vehicle_id &&
                $mail->token === $invite2->verification_token; // Change to $token here
        });
    }



    #[Test]
    public function test_handle_does_not_send_emails_if_no_invites(): void
    {
        // Arrange
        Mail::fake();

        $user = User::factory()->create();

        // Act: Simulate the Verified event
        $event = new Verified($user);
        $listener = new SendInviteMail();
        $listener->handle($event);

        // Assert: No emails were sent
        Mail::assertNothingSent();
    }
}
