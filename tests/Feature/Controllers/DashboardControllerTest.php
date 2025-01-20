<?php
namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_show_dashboard_for_authenticated_user_without_vehicle()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Ustawiamy zalogowanego użytkownika
        $this->actingAs($user);

        // Wywołujemy akcję kontrolera bez przekazania pojazdu
        $response = $this->get(route('dashboard')); // Używamy dashboard zamiast dashboard.show

        // Sprawdzamy, czy odpowiedź zawiera odpowiednie dane z Inertia
        $response->assertInertia(fn (AssertableInertia $inertia) =>
        $inertia->component('Dashboard')
            ->has('spendings')
            ->where('vehicles', fn ($vehicles) => $vehicles->count() === 0)  // Oczekujemy, że użytkownik nie ma pojazdów
            ->where('vehicle', null)  // Vehicle powinno być null
            ->where('userid', $user->id) // ID użytkownika powinno być przekazane
        );
    }
    #[Test]
    public function test_show_dashboard_for_authenticated_user_with_vehicle()
    {
        // Tworzymy użytkownika i pojazd
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $user->id,
        ]);

        // Przypisujemy pojazd do użytkownika, dodając wartość dla 'role'
        $user->vehicles()->attach($vehicle->id, ['status' => 'active', 'role' => 'admin']);

        // Ustawiamy zalogowanego użytkownika
        $this->actingAs($user);

        // Wywołujemy akcję kontrolera, przekazując pojazd
        $response = $this->get(route('dashboard', ['vehicle' => $vehicle->id])); // Używamy dashboard zamiast dashboard.show

        // Sprawdzamy, czy odpowiedź zawiera odpowiednie dane z Inertia
        $response->assertInertia(fn (AssertableInertia $inertia) =>
        $inertia->component('Dashboard')
            ->has('spendings')  // Sprawdzamy, czy są wydatki
            ->where('vehicles', fn ($vehicles) => $vehicles->count() > 0)  // Sprawdzamy, czy pojazd jest przypisany do użytkownika
            ->where('vehicle', fn ($vehicleData) => $vehicleData['id'] === $vehicle->id)  // Sprawdzamy, czy pojazd jest odpowiedni
            ->where('userid', $user->id) // ID użytkownika powinno być przekazane
        );
    }
}



