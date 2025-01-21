<?php

namespace Tests\Unit\Models;

use App\Models\Vehicle;
use App\Models\User;
use App\Models\Spending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;


    #[Test]
    public function vehicle_belongs_to_many_users()
    {
        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        // Związanie pojazdu z użytkownikiem
        $vehicle->users()->attach($user, ['role' => 'driver', 'status' => 'active']);

        // Sprawdzamy, czy pojazd ma przypisanego użytkownika
        $this->assertCount(1, $vehicle->users);
        $this->assertEquals('driver', $vehicle->users->first()->pivot->role);
    }

    #[Test]
    public function vehicle_belongs_to_owner_user()
    {
        $owner = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['owner_id' => $owner->id]);

        // Sprawdzamy, czy pojazd należy do właściciela
        $this->assertEquals($owner->id, $vehicle->user->id);
    }

    #[Test]
    public function vehicle_has_spendings()
    {
        $vehicle = Vehicle::factory()->create();
        $spending = Spending::factory()->create(['vehicle_id' => $vehicle->id]);

        // Sprawdzamy, czy pojazd ma przypisane wydatki
        $this->assertCount(1, $vehicle->spendings);
        $this->assertEquals($spending->id, $vehicle->spendings->first()->id);
    }
}
