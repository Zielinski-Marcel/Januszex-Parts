<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Spending;
use App\Models\Vehicle;
use App\Models\Invite;
use App\Notifications\VerifyAccountNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function user_can_be_created()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123'),
            'is_admin' => false,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
            'name' => 'John Doe',
        ]);
    }

    #[Test]
    public function user_has_vehicles()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();
        $user->vehicles()->attach($vehicle, ['role' => 'owner', 'status' => 'active']);

        $this->assertCount(1, $user->vehicles);
        $this->assertEquals('owner', $user->vehicles->first()->pivot->role);
    }

    #[Test]
    public function user_has_spendings()
    {
        $user = User::factory()->create();
        $spending = Spending::factory()->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->spendings);
        $this->assertEquals($spending->id, $user->spendings->first()->id);
    }

    #[Test]
    public function user_has_vehicle_with_owner_id()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['owner_id' => $user->id]);

        $this->assertCount(1, $user->vehicle);
        $this->assertEquals($vehicle->id, $user->vehicle->first()->id);
    }

    #[Test]
    public function send_email_verification_notification()
    {
        Notification::fake();

        $user = User::factory()->create();

        // Wywołujemy metodę, która wysyła powiadomienie
        $user->sendEmailVerificationNotification();

        // Sprawdzamy, czy powiadomienie zostało wysłane
        Notification::assertSentTo($user, VerifyAccountNotification::class);
    }

    #[Test]
    public function get_invites_returns_invites_for_user_email()
    {
        $user = User::factory()->create(['email' => 'johndoe@example.com']);
        $invitor = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        // Tworzymy zaproszenie, które będzie pasować do użytkownika
        Invite::create([
            'invitor_id' => $invitor->id,
            'email' => 'johndoe@example.com',
            'vehicle_id' => $vehicle->id,
            'status' => 'pending',
        ]);

        $invites = $user->getInvites();

        // Sprawdzamy, czy zaproszenie jest poprawnie zwrócone
        $this->assertCount(1, $invites);
        $this->assertEquals('johndoe@example.com', $invites->first()->email);
        $this->assertEquals($vehicle->id, $invites->first()->vehicle->id);
    }
}
