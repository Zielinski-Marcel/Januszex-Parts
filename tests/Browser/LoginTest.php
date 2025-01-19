<?php

namespace Tests\Browser;

use App\Models\User; // Import modelu User
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Tworzy użytkownika w bazie danych testowej.
     *
     * @return User
     */
    protected function createTestUser(): User
    {
        return User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'), // Hasło musi być zaszyfrowane
        ]);
    }

    /**
     * Testowanie logowania.
     *
     * @return void
     */
    public function testLogin()
    {
        // Utwórz użytkownika testowego
        $this->createTestUser();

        // Wykonaj test logowania
        $this->browse(function (Browser $browser) {
            $browser->visit('http://web-CCH/login') // Odwiedź stronę logowania
            ->pause(2000) // Wstrzymaj ładowanie
            ->screenshot('login_page') // Zrzut ekranu dla debugowania
            ->type('email', 'test@example.com') // Wypełnij email
            ->type('password', 'password123') // Wypełnij hasło
            ->waitFor('.inline-flex.items-center', 10) // Oczekuj na pojawienie się przycisku
            ->click('.inline-flex.items-center') // Kliknij przycisk
            ->pause(3000) // Wstrzymaj, aby upewnić się, że strona się przekierowała
            ->assertPathIs('/dashboard') // Sprawdź, czy trafiłeś na stronę dashboard
            ->screenshot('dashboard_page'); // Zrzut ekranu po logowaniu
        });
    }
}

