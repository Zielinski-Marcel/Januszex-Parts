<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_edit_profile()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Logujemy użytkownika
        $this->actingAs($user);

        // Wysyłamy zapytanie GET do endpointu edycji profilu
        $response = $this->get(route('profile.edit'));

        // Sprawdzamy, czy odpowiedź jest poprawna (status 200)
        $response->assertStatus(200);

        // Sprawdzamy, czy odpowiedź zawiera dane użytkownika
        $response->assertInertia(fn ($inertia) => $inertia
            ->component('Profile/Edit')
            ->has('vehicles.owned')
            ->has('vehicles.shared')
        );
    }

    #[Test]
    public function test_update_profile()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Logujemy użytkownika
        $this->actingAs($user);

        // Przygotowujemy dane do aktualizacji
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        // Wysyłamy zapytanie PATCH do aktualizacji profilu
        $response = $this->patch(route('profile.update'), $updatedData);

        // Sprawdzamy, czy użytkownik został przekierowany do strony edycji
        $response->assertRedirect(route('profile.edit'));

        // Sprawdzamy, czy dane użytkownika zostały zaktualizowane
        $this->assertDatabaseHas('users', $updatedData);
    }

    #[Test]
    public function test_destroy_profile()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Logujemy użytkownika
        $this->actingAs($user);

        // Przygotowujemy dane do żądania (aktualne hasło)
        $passwordData = [
            'password' => 'password', // Hasło musiałoby być takie samo, jak to używane przy tworzeniu użytkownika
        ];

        // Wysyłamy zapytanie DELETE do usunięcia konta
        $response = $this->delete(route('profile.destroy'), $passwordData);

        // Sprawdzamy, czy użytkownik został przekierowany na stronę główną
        $response->assertRedirect('/');

        // Sprawdzamy, czy użytkownik został usunięty z bazy danych
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
