<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_get_user_not_found()
    {
        // Wysyłamy zapytanie GET do endpointu /user/{id} z nieistniejącym ID
        $response = $this->getJson("/user/999999");

        // Sprawdzamy, czy odpowiedź zawiera status 404 (użytkownik nie znaleziony)
        $response->assertStatus(404);
    }
}
