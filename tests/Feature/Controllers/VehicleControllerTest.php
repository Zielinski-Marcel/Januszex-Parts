<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Vehicle;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_create_vehicle_success()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Tworzymy dane do wysłania
        $data = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year_of_manufacture' => 2022,
            'fuel_type' => 'Petrol',
            'purchase_date' => 2022,
            'color' => 'Red',
        ];

        // Logujemy użytkownika
        $this->actingAs($user);

        // Wykonujemy zapytanie POST do kontrolera, aby utworzyć pojazd
        $response = $this->post(route('createVehicle'), $data);

        // Sprawdzamy, czy pojazd został zapisany w bazie danych
        $this->assertDatabaseHas('vehicles', [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year_of_manufacture' => 2022,
            'fuel_type' => 'Petrol',
            'purchase_date' => 2022,
            'color' => 'Red',
        ]);

        // Sprawdzamy, czy użytkownik jest przypisany do pojazdu w tabeli przestawnej
        $this->assertDatabaseHas('user_vehicle', [
            'user_id' => $user->id,
            'vehicle_id' => Vehicle::where('model', 'Corolla')->first()->id,
            'role' => 'owner',
            'status' => 'active',
        ]);

        // Sprawdzamy, czy przekierowanie działa poprawnie
        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function test_delete_vehicle_success()
    {
        // Przygotowanie danych testowych
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $user->id,
        ]);

        // Logowanie użytkownika
        $this->actingAs($user);

        // Wykonanie DELETE requestu do usunięcia pojazdu
        $response = $this->delete(route('deleteVehicle', ['id' => $vehicle->id]));

        // Sprawdzanie, czy pojazd został usunięty z bazy danych
        $this->assertDatabaseMissing('vehicles', [
            'id' => $vehicle->id,
        ]);

        // Sprawdzanie, czy użytkownik został przekierowany z komunikatem o powodzeniu
        $response->assertRedirect();
        $response->assertSessionHas('status', 'Vehicle deleted successfully.');
    }

    #[Test]
    public function test_delete_vehicle_not_owner()
    {
        // Przygotowanie danych testowych
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $otherUser->id, // Inny użytkownik jest właścicielem pojazdu
        ]);

        // Logowanie użytkownika, który nie jest właścicielem pojazdu
        $this->actingAs($user);

        // Wykonanie DELETE requestu do usunięcia pojazdu
        $response = $this->delete(route('deleteVehicle', ['id' => $vehicle->id]));

        // Sprawdzanie, czy pojazd nie został usunięty
        $this->assertDatabaseHas('vehicles', [
            'id' => $vehicle->id,
        ]);

        // Sprawdzanie, czy pojazd nie został usunięty i zwrócenie błędu 404
        $response->assertStatus(404);
    }

    #[Test]
    public function test_delete_vehicle_not_found()
    {
        // Przygotowanie danych testowych
        $user = User::factory()->create();

        // Logowanie użytkownika
        $this->actingAs($user);

        // Wykonanie DELETE requestu do usunięcia pojazdu, który nie istnieje
        $response = $this->delete(route('deleteVehicle', ['id' => 9999])); // Pojazd o ID 9999 nie istnieje

        // Sprawdzanie, czy otrzymano błąd 404
        $response->assertStatus(404);
    }

    #[Test]
    public function test_remove_user_from_vehicle_success()
    {
        // Tworzymy dwóch użytkowników i pojazd
        $owner = User::factory()->create();
        $userToRemove = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $owner->id,
        ]);

        // Przypisujemy użytkownika do pojazdu
        $vehicle->users()->attach($userToRemove, [
            'role' => 'shared',
            'status' => 'active',
        ]);

        // Logujemy właściciela
        $this->actingAs($owner);

        // Wykonujemy żądanie do usunięcia użytkownika z pojazdu
        $response = $this->delete(route('removeUserFromVehicle', ['vehicle_id' => $vehicle->id, 'user_id' => $userToRemove->id]));

        // Sprawdzamy, czy użytkownik został oznaczony jako nieaktywny
        $this->assertDatabaseHas('user_vehicle', [
            'vehicle_id' => $vehicle->id,
            'user_id' => $userToRemove->id,
            'status' => 'inactive',
        ]);

        // Sprawdzamy, czy użytkownik został usunięty z pojazdu
        $response->assertRedirect();
        $response->assertSessionHas('status', 'User deleted successfully.');
    }
    #[Test]
    public function test_user_is_not_owner_of_vehicle_should_receive_403()
    {
        // Tworzymy dwóch użytkowników
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        // Tworzymy pojazd przypisany do właściciela
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $owner->id,
        ]);

        // Ustawiamy zalogowanego użytkownika na 'otherUser'
        $this->actingAs($otherUser);

        // Próbujemy edytować pojazd, oczekujemy 403
        $response = $this->get('/edit/vehicle/' . $vehicle->id);

        $response->assertStatus(403);
    }
}

