<?php
namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Mockery;

class SocialAuthControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_redirect_to_facebook()
    {
        // Symulujemy użytkownika, aby był zalogowany.
        $user = User::factory()->create();
        $this->actingAs($user);

        // Wysyłamy zapytanie GET do endpointu /login/facebook.
        $response = $this->get(route('auth.facebook'));

        // Sprawdzamy, czy odpowiedź to przekierowanie do Facebooka.
        $response->assertRedirect();
        $this->assertStringContainsString('facebook.com', $response->headers->get('Location'));
    }
}
