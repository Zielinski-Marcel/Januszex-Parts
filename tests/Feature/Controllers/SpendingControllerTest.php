<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Spending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SpendingControllerTest extends TestCase
{
    use RefreshDatabase;
    #[Test]
    public function test_create_spending()
    {
        // Tworzymy użytkownika i pojazd
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do użytkownika
        $user->vehicles()->attach($vehicle->id, ['role' => 'owner', 'status' => 'active']);

        // Uwierzytelnianie użytkownika
        $this->actingAs($user);

        // Wysyłamy żądanie POST do utworzenia wydatku
        $response = $this->post(route('createSpending', ['vehicle_id' => $vehicle->id]), [
            'price' => 100.00,
            'date' => now(),
            'type' => 'Fuel',
            'place' => 'Gas Station',
            'description' => 'Fuel purchase',
        ]);

        // Sprawdzamy, czy wydatek został zapisany w bazie danych
        $response->assertRedirect("/dashboard/{$vehicle->id}");
        $this->assertDatabaseHas('spendings', [
            'price' => 100.00,
            'description' => 'Fuel purchase',
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id
        ]);
    }
    #[Test]
    public function test_edit_spending()
    {
        // Tworzymy użytkownika i pojazd
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do użytkownika
        $user->vehicles()->attach($vehicle->id, ['role' => 'owner', 'status' => 'active']);

        // Tworzymy wydatek
        $spending = Spending::factory()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id
        ]);

        // Uwierzytelnianie użytkownika
        $this->actingAs($user);

        // Wysyłamy zapytanie PUT do edycji wydatku
        $response = $this->put(route('editSpending', ['spending' => $spending->id]), [
            'price' => 150.00,
            'date' => now(),
            'type' => 'Maintenance',
            'place' => 'Garage',
            'description' => 'Car maintenance',
        ]);

        // Sprawdzamy, czy wydatek został zaktualizowany w bazie
        $response->assertRedirect("/dashboard/{$vehicle->id}");
        $this->assertDatabaseHas('spendings', [
            'id' => $spending->id,
            'price' => 150.00,
            'description' => 'Car maintenance'
        ]);
    }
    #[Test]
    public function test_delete_spending()
    {
        // Tworzymy użytkownika i pojazd
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do użytkownika
        $user->vehicles()->attach($vehicle->id, ['role' => 'owner', 'status' => 'active']);

        // Tworzymy wydatek
        $spending = Spending::factory()->create([
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id
        ]);

        // Uwierzytelnianie użytkownika
        $this->actingAs($user);

        // Wysyłamy zapytanie DELETE do usunięcia wydatku
        $response = $this->delete(route('deleteSpending', ['spending' => $spending->id]));

        // Sprawdzamy, czy wydatek został usunięty
        $response->assertRedirect();
        $this->assertDatabaseMissing('spendings', [
            'id' => $spending->id
        ]);
    }
}
