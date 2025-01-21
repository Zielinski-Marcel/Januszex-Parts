<?php

namespace Tests\Unit\Models;

use App\Models\Spending;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SpendingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function spending_can_be_created()
    {
        // Tworzymy użytkownika i pojazd
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        // Tworzymy wydatek
        $spending = Spending::create([
            'price' => 100.50,
            'type' => 'Fuel',
            'date' => now(),
            'place' => 'City Center',
            'description' => 'Fuel for the car',
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
        ]);

        // Sprawdzamy, czy rekord został zapisany w bazie danych
        $this->assertDatabaseHas('spendings', [
            'price' => 100.50,
            'type' => 'Fuel',
            'place' => 'City Center',
            'description' => 'Fuel for the car',
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
        ]);
    }

    #[Test]
    public function spending_belongs_to_user()
    {
        // Tworzymy użytkownika i wydatek
        $user = User::factory()->create();
        $spending = Spending::factory()->create(['user_id' => $user->id]);

        // Sprawdzamy, czy wydatek należy do użytkownika
        $this->assertInstanceOf(User::class, $spending->user);
        $this->assertEquals($user->id, $spending->user->id);
    }

    #[Test]
    public function spending_belongs_to_vehicle()
    {
        // Tworzymy pojazd i wydatek
        $vehicle = Vehicle::factory()->create();
        $spending = Spending::factory()->create(['vehicle_id' => $vehicle->id]);

        // Sprawdzamy, czy wydatek należy do pojazdu
        $this->assertInstanceOf(Vehicle::class, $spending->vehicle);
        $this->assertEquals($vehicle->id, $spending->vehicle->id);
    }

    #[Test]
    public function price_is_casted_to_float()
    {
        // Tworzymy wydatek
        $spending = Spending::factory()->create(['price' => '123.45']);

        // Sprawdzamy, czy cena jest traktowana jako float
        $this->assertIsFloat($spending->price);
        $this->assertEquals(123.45, $spending->price);
    }

    #[Test]
    public function date_is_casted_to_datetime()
    {
        // Tworzymy wydatek z datą
        $spending = Spending::factory()->create(['date' => '2025-01-21 12:00:00']);

        // Sprawdzamy, czy data została poprawnie sparsowana do obiektu DateTime
        $this->assertInstanceOf(\Carbon\Carbon::class, $spending->date);
        $this->assertEquals('2025-01-21 12:00:00', $spending->date->format('Y-m-d H:i:s'));
    }
}
