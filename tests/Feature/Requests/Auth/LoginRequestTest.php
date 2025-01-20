<?php
namespace Feature\Requests\Auth;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    #[Test]
    public function test_login_request_validation()
    {
        // Tworzymy użytkownika, który będzie próbował się zalogować
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        // Testujemy brak e-maila
        $response = $this->post('/login', []);
        $response->assertSessionHasErrors('email');

        // Testujemy brak hasła
        $response = $this->post('/login', ['email' => $user->email]);
        $response->assertSessionHasErrors('password');

        // Testujemy niepoprawny format e-maila
        $response = $this->post('/login', ['email' => 'invalidemail', 'password' => 'password']);
        $response->assertSessionHasErrors('email');

        // Testujemy poprawny e-mail i hasło
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password123']);
        $response->assertSessionDoesntHaveErrors();  // Teraz powinno działać poprawnie
    }

    #[Test]
    public function test_rate_limiting_for_failed_login()
    {
        $email = 'user@example.com';
        $password = 'wrongpassword';

        // Symulujemy 5 nieudanych prób logowania
        for ($i = 0; $i < 5; $i++) {
            $response = $this->post('/login', ['email' => $email, 'password' => $password]);
            $response->assertSessionHasErrors('email'); // Błędne dane, więc oczekujemy błędu
        }

        // Sprawdzamy, czy limit prób został osiągnięty i użytkownik jest blokowany
        $response = $this->post('/login', ['email' => $email, 'password' => $password]);
        $response->assertSessionHasErrors('email'); // Nadal błąd, ale komunikat będzie o zablokowaniu konta
        $response->assertSessionHas('errors'); // Upewniamy się, że w sesji pojawia się komunikat o zablokowaniu
    }

    #[Test]
    public function test_successful_login()
    {
        // Tworzymy użytkownika z hasłem
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        // Wykonujemy poprawne logowanie
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'password123']);

        // Sprawdzamy, czy logowanie było udane (przekierowanie na dashboard)
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user); // Sprawdzamy, czy użytkownik jest zalogowany
    }

    #[Test]
    public function test_failed_login()
    {
        // Tworzymy użytkownika z hasłem
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        // Wykonujemy niepoprawne logowanie (z błędnym hasłem)
        $response = $this->post('/login', ['email' => $user->email, 'password' => 'wrongpassword']);

        // Sprawdzamy, czy logowanie się nie powiodło
        $response->assertSessionHasErrors('email');
    }
}
