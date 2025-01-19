<?php

namespace Tests\Browser;

use App\Models\User; // Import modelu User
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Tworzy użytkownika w bazie danych testowej.
     *
     * @return User
     */
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
        // Utwórz użytkownika testowego
        $this->artisan('migrate:refresh');
        $this->createTestUser();

        // Wykonaj test logowania
        $this->browse(function (Browser $browser) {
            $browser->visit('http://web-CCH/login') // Odwiedź stronę logowania
            ->pause(2000) // Wstrzymaj ładowanie
            ->screenshot('LoginTestScreenShots/login_page') // Zrzut ekranu dla debugowania
            ->type('email', 'test@example.com') // Wypełnij email
            ->screenshot('LoginTestScreenShots/login_page_email') // Zrzut ekranu dla debugowania
            ->type('password', 'password123') // Wypełnij hasło
            ->screenshot('LoginTestScreenShots/login_page_password') // Zrzut ekranu dla debugowania
            ->waitFor('.inline-flex.items-center', 10) // Oczekuj na pojawienie się przycisku
            ->click('.inline-flex.items-center') // Kliknij przycisk
            ->pause(3000) // Wstrzymaj, aby upewnić się, że strona się przekierowała
            ->assertPathIs('/dashboard') // Sprawdź, czy trafiłeś na stronę dashboard
            ->screenshot('LoginTestScreenShots/dashboard_page'); // Zrzut ekranu po logowaniu
        });
    }
}

