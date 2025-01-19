<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\File;

class ForgotPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Testowanie zapomnianego hasła.
     *
     * @return void
     */
    public function testForgotPassword()
    {
        // Katalog na zrzuty ekranu
        $screenshotsDir = base_path('/ForgotPasswordTestScreenShots');

        // Upewnij się, że katalog istnieje
        if (!File::exists($screenshotsDir)) {
            File::makeDirectory($screenshotsDir, 0755, true);
        }

        // Utwórz użytkownika testowego
        $this->artisan('migrate:refresh');
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->browse(function (Browser $browser) use ($screenshotsDir, $user) {
            $browser->visit('http://web-CCH/login')
                ->pause(2000) // Wstrzymaj ładowanie
                ->screenshot($screenshotsDir . '/login_page') // Zrzut ekranu strony logowania
                ->assertPathIs('/login')
                ->clickLink('Forgot your password?')
                ->pause(2000) // Wstrzymaj, aby upewnić się, że strona resetowania hasła jest załadowana
                ->screenshot($screenshotsDir . '/forgot-password_page') // Zrzut ekranu strony zapomnianego hasła
                ->assertPathIs('/forgot-password')
                ->type('email', 'test@example.com')
                ->screenshot($screenshotsDir . '/forgot-password_email') // Zrzut ekranu po wpisaniu emaila
                ->assertPathIs('/forgot-password')
                ->click('.inline-flex.items-center') // Zakładając, że przycisk ma odpowiednią klasę
                ->pause(3000) // Wstrzymaj, aby upewnić się, że proces wysyłania linku został zakończony
                ->assertSee('We have emailed your password reset link.') // Komunikat o wysłaniu linku
                ->screenshot($screenshotsDir . '/password_reset_link_sent') // Zrzut ekranu po wysłaniu linku
                ->assertPathIs('/forgot-password');
        });
    }
}
