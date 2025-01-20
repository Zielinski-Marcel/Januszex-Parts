<?php
namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Invite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Mail\Invite as InviteMail;
use App\Mail\InviteIfNoAccount;

class InviteControllerTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function test_store_invite_for_user_with_account()
    {
        // Użytkownik wysyłający zaproszenie
        $invitor = User::factory()->create();

        // Tworzymy pojazd przypisany do użytkownika
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $invitor->id,
        ]);

        // Użytkownik otrzymujący zaproszenie (z kontem)
        $invitee = User::factory()->create();

        // Symulujemy logowanie zapraszającego użytkownika
        $this->actingAs($invitor);

        // Zaproszenie zostanie wysłane na ten adres email
        $email = $invitee->email;

        // Weryfikujemy, czy zaproszenie zostało wysłane
        Mail::fake();

        // Wysyłamy zaproszenie
        $response = $this->post(route('store'), [
            'vehicle_id' => $vehicle->id,
            'email' => $email,
        ]);

        // Sprawdzamy, czy zaproszenie zostało utworzone w bazie danych
        $this->assertDatabaseHas('invites', [
            'vehicle_id' => $vehicle->id,
            'email' => $email,
            'status' => 'pending',
        ]);

        // Sprawdzamy, czy zaproszenie zostało wysłane
        Mail::assertSent(InviteMail::class, function ($mail) use ($invitee, $invitor, $vehicle) {
            return $mail->hasTo($invitee->email) &&
                $mail->invitor->id === $invitor->id &&
                $mail->vehicle->id === $vehicle->id;
        });

        // Sprawdzamy, czy użytkownik został przekierowany
        $response->assertRedirect()->with('status', 'Invitation sent successfully.');
    }
    #[Test]
    public function test_store_invite_for_unauthorized_vehicle()
    {
        // Użytkownik wysyłający zaproszenie
        $invitor = User::factory()->create();

        // Tworzymy pojazd przypisany do innego użytkownika
        $vehicle = Vehicle::factory()->create();

        // Symulujemy logowanie zapraszającego użytkownika
        $this->actingAs($invitor);

        // Próba wysłania zaproszenia na nieautoryzowany pojazd
        $response = $this->post(route('store'), [
            'vehicle_id' => $vehicle->id,
            'email' => 'invitee@example.com',
        ]);

        // Sprawdzamy, czy odpowiedź to błąd 404
        $response->assertStatus(404);
    }
}
