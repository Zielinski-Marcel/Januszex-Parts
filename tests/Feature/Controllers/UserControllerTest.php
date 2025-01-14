<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test sprawdzający, czy użytkownik nie istnieje (404).
     *
     * @return void
     */
    public function test_get_user_not_found()
    {
        // Wysyłamy zapytanie GET do endpointu /user/{id} z nieistniejącym ID
        $response = $this->getJson("/user/999999");

        // Sprawdzamy, czy odpowiedź zawiera status 404 (użytkownik nie znaleziony)
        $response->assertStatus(404);
    }

    /**
     * Test sprawdzający, czy użytkownik może zostać utworzony (stubs).
     *
     * @return void
     */
    public function test_create_user()
    {
        // Wysyłamy zapytanie POST do endpointu /user
        $response = $this->postJson('/user');

        // Sprawdzamy, czy odpowiedź zawiera status 200
        $response->assertStatus(200);
        $response->assertJson([]);
    }
}
