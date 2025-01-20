<?php

namespace Tests\Browser;

use App\Models\User; // Import modelu User
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\File;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    #[Test]
    protected function createTestUser(): User
    {
        // Dodaj flush() lub po prostu uruchom zapisanie do bazy, żeby upewnić się, że migracje zostały zastosowane
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Dodatkowe sprawdzenie, czy użytkownik został zapisany
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        return $user;
    }

    /**
     * Testowanie logowania.
     *
     * @return void
     */
    public function testLogin()
    {
        // Katalog na zrzuty ekranu
        $screenshotsDir = base_path('tests/Browser/screenshots/LoginTestScreenShots');


        // Utwórz użytkownika testowego
        $this->artisan('migrate:refresh');
        $this->createTestUser();

        // Wykonaj test logowania
        $this->browse(function (Browser $browser) use ($screenshotsDir) {
            $browser->visit('http://web-CCH/login') // Odwiedź stronę logowania
            ->pause(2000) // Wstrzymaj ładowanie
            ->screenshot($screenshotsDir . '/login_page') // Zrzut ekranu strony logowania
            ->assertPathIs('/login')
            ->type('email', 'test@example.com') // Wypełnij email
            ->screenshot($screenshotsDir . '/login_page_email') // Zrzut ekranu po wpisaniu emaila
            ->type('password', 'password123') // Wypełnij hasło
            ->screenshot($screenshotsDir . '/login_page_password') // Zrzut ekranu po wpisaniu hasła
            ->assertPathIs('/login')
            ->waitFor('.inline-flex.items-center', 10) // Oczekuj na pojawienie się przycisku
            ->click('.inline-flex.items-center') // Kliknij przycisk
            ->pause(3000) // Wstrzymaj, aby upewnić się, że strona się przekierowała
            ->screenshot($screenshotsDir . '/dashboard_page') // Zrzut ekranu po pomyślnym logowaniu
            ->assertPathIs('/dashboard'); // Sprawdź, czy trafiłeś na stronę dashboard
        });
    }
}

