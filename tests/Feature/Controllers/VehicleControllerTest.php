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

    // Używamy tego, aby każda metoda testowa miała świeżą bazę danych

    #[Test]
    public function test_get_vehicle_success()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Tworzymy pojazd
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do użytkownika z odpowiednim statusem i rolą
        $user->vehicles()->attach($vehicle->id, ['status' => 'active', 'role' => 'owner']);

        // Logujemy użytkownika
        $this->actingAs($user);

        // Wykonujemy zapytanie do kontrolera, aby pobrać pojazd
        $response = $this->getJson(route('getVehicle', ['id' => $vehicle->id]));

        // Sprawdzamy, czy odpowiedź jest poprawna (200 OK)
        $response->assertStatus(200);

        // Sprawdzamy, czy odpowiedź zawiera poprawne dane pojazdu
        $response->assertJson([
            'vehicle' => [
                'id' => $vehicle->id,
                'brand' => $vehicle->brand,  // Sprawdź, czy pojazd ma odpowiednią markę w odpowiedzi
                'model' => $vehicle->model,
                // Dodaj więcej pól, jeśli są dostępne w Twoim modelu pojazdu
            ],
        ]);
    }

    #[Test]
    public function test_get_vehicle_not_found()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Tworzymy pojazd
        $vehicle = Vehicle::factory()->create();

        // Tworzymy innego użytkownika i przypisujemy pojazd do niego
        $otherUser = User::factory()->create();
        $otherUser->vehicles()->attach($vehicle->id, ['status' => 'active', 'role' => 'owner']);

        // Logujemy użytkownika
        $this->actingAs($user);

        // Wykonujemy zapytanie do kontrolera, aby pobrać pojazd, który nie należy do użytkownika
        $response = $this->getJson(route('getVehicle', ['id' => $vehicle->id]));

        // Sprawdzamy, czy odpowiedź ma status 404, ponieważ pojazd nie należy do użytkownika
        $response->assertStatus(404);

        // Sprawdzamy, czy odpowiedź zawiera odpowiedni komunikat
        $response->assertJson([
            'message' => 'Vehicle not found or does not belong to the authenticated user.',
        ]);
    }

    #[Test]
    public function test_get_vehicle_not_active()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Tworzymy pojazd
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do użytkownika, ale ustawiamy status na 'inactive' i rolę 'owner'
        $user->vehicles()->attach($vehicle->id, ['status' => 'inactive', 'role' => 'owner']);

        // Logujemy użytkownika
        $this->actingAs($user);

        // Wykonujemy zapytanie do kontrolera, aby pobrać pojazd, który ma status 'inactive'
        $response = $this->getJson(route('getVehicle', ['id' => $vehicle->id]));

        // Sprawdzamy, czy odpowiedź ma status 404, ponieważ pojazd nie jest aktywny
        $response->assertStatus(404);

        // Sprawdzamy, czy odpowiedź zawiera odpowiedni komunikat
        $response->assertJson([
            'message' => 'Vehicle not found or does not belong to the authenticated user.',
        ]);
    }

    #[Test]
    public function test_get_vehicles_no_active_vehicles()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Tworzymy pojazd
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do użytkownika, ale ustawiamy status na 'inactive'
        $user->vehicles()->attach($vehicle->id, ['status' => 'inactive', 'role' => 'owner']);

        // Logujemy użytkownika
        $this->actingAs($user);

        // Wykonujemy zapytanie do kontrolera, aby pobrać pojazdy
        $response = $this->getJson(route('getVehicles'));

        // Sprawdzamy, czy odpowiedź ma status 200, ale brak pojazdów
        $response->assertStatus(200);

        // Sprawdzamy, czy odpowiedź zawiera pustą tablicę pojazdów
        $response->assertJson([
            'vehicles' => [],
        ]);
    }

    #[Test]
    public function test_get_vehicles_other_user_vehicle()
    {
        // Tworzymy dwóch użytkowników
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        // Tworzymy pojazd
        $vehicle = Vehicle::factory()->create();

        // Przypisujemy pojazd do innego użytkownika
        $otherUser->vehicles()->attach($vehicle->id, ['status' => 'active', 'role' => 'owner']);

        // Logujemy pierwszego użytkownika
        $this->actingAs($user);

        // Wykonujemy zapytanie do kontrolera, aby pobrać pojazdy
        $response = $this->getJson(route('getVehicles'));

        // Sprawdzamy, czy odpowiedź zawiera pustą tablicę, ponieważ pojazd nie należy do użytkownika
        $response->assertJson([
            'vehicles' => [],
        ]);
    }

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
    public function test_create_vehicle_unauthenticated()
    {
        // Tworzymy dane do wysłania
        $data = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year_of_manufacture' => 2022,
            'fuel_type' => 'Petrol',
            'purchase_date' => 2022,
            'color' => 'Red',
        ];

        // Wykonujemy zapytanie POST do kontrolera, ale bez logowania
        $response = $this->post(route('createVehicle'), $data);

        // Sprawdzamy, czy odpowiedź ma status 401 (nieautoryzowany)
        $response->assertStatus(401);
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

