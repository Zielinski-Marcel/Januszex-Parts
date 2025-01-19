<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test sprawdzający poprawność wyświetlania profilu użytkownika.
     *
     * @return void
     */
    public function test_show_profile()
    {
        // Tworzymy użytkownika
        $user = User::factory()->create();

        // Wysyłamy zapytanie GET do endpointu /user/{username}
        $response = $this->get('/user/' . $user->name);

        // Sprawdzamy, czy odpowiedź jest poprawna (status 200)
        $response->assertStatus(200);

        // Dodatkowo sprawdzamy, czy użytkownik o odpowiednim ID jest zwrócony
        $response->assertViewHas('user', $user);
    }

    /**
     * Test sprawdzający, czy użytkownik nie jest znaleziony, jeśli nie istnieje.
     *
     * @return void
     */
    public function test_show_profile_not_found()
    {
        // Wysyłamy zapytanie GET do nieistniejącego użytkownika
        $response = $this->get('/user/nonexistentuser');

        // Sprawdzamy, czy zwrócono status 404
        $response->assertStatus(404);

        // Sprawdzamy, czy odpowiedź zawiera komunikat o błędzie
        $response->assertJson(['message' => 'Użytkownik nie został znaleziony.']);
    }

    /**
     * Test sprawdzający poprawność wyświetlania formularza edycji profilu.
     *
     * @return void
     */
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

    /**
     * Test aktualizacji profilu użytkownika.
     *
     * @return void
     */
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

    /**
     * Test usunięcia konta użytkownika.
     *
     * @return void
     */
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
