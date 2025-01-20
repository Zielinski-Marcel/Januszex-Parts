<?php

namespace Tests\Feature\Controllers\Admin;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test; // Import atrybutu Test
use Tests\TestCase;
use Spatie\Activitylog\Models\Activity;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_admin_dashboard()
    {
        // Tworzymy administratora
        $admin = User::factory()->create([
            'is_admin' => true
        ]);

        // Tworzymy zwykłego użytkownika
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        // Tworzymy pojazdy dla użytkownika
        $vehicle1 = Vehicle::factory()->create([
            'owner_id' => $user->id, // Przypisujemy pojazd do użytkownika
        ]);
        $vehicle2 = Vehicle::factory()->create([
            'owner_id' => $user->id, // Przypisujemy pojazd do użytkownika
        ]);

        // Tworzymy powiązanie między użytkownikiem a pojazdami, przypisując rolę i status
        $user->vehicles()->attach([
            $vehicle1->id => ['role' => 'owner', 'status' => 'accepted'],
            $vehicle2->id => ['role' => 'owner', 'status' => 'accepted']
        ]);

        // Logujemy administratora
        $this->actingAs($admin);

        // Wysyłamy zapytanie do kontrolera
        $response = $this->get(route('admin'));  // Upewnij się, że masz odpowiednią trasę

        // Sprawdzamy, czy odpowiedź jest poprawna
        $response->assertStatus(200);

        // Sprawdzamy, czy dane o użytkowniku i użytkownikach są zwrócone
        $response->assertInertia(fn ($page) =>
        $page->has('admin')  // Sprawdzamy, czy dane administratora są dostępne
        ->has('users')   // Sprawdzamy, czy dane użytkowników są dostępne
        ->where('admin.id', $admin->id)  // ID administratora
        );

        // Sprawdzamy, czy aktywność o dostępie do panelu administratora została zapisana w tabeli activity_log
        $this->assertDatabaseHas('activity_log', [
            'description' => 'Accessed the admin dashboard.',
            'causer_id' => $admin->id,
        ]);
    }

    #[Test]
    public function it_does_not_show_non_admin_dashboard()
    {
        // Tworzymy zwykłego użytkownika
        $user = User::factory()->create([
            'is_admin' => false
        ]);

        // Logujemy użytkownika, który nie jest administratorem
        $this->actingAs($user);

        // Wysyłamy zapytanie do kontrolera
        $response = $this->get(route('admin'));

        // Sprawdzamy, czy użytkownik, który nie jest administratorem, otrzymuje odpowiednią odpowiedź
        $response->assertStatus(403); // Oczekujemy statusu 403 - Forbidden
    }
}
