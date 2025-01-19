<?php
namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\File;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Testowanie rejestracji.
     *
     * @return void
     */
    public function testRegister()
    {
        // Katalog na zrzuty ekranu
        $screenshotsDir = base_path('tests/Browser/screenshots/RegisterTestScreenShots');

        // Upewnij się, że katalog istnieje
        if (!File::exists($screenshotsDir)) {
            File::makeDirectory($screenshotsDir, 0755, true);
        }
        $this->artisan('migrate:refresh');
        // Wykonaj test rejestracji
        $this->browse(function (Browser $browser) use ($screenshotsDir) {
            // Odwiedź stronę logowania
            $browser->visit('http://web-CCH/login')
                ->pause(2000) // Wstrzymaj ładowanie
                ->screenshot($screenshotsDir . '/login_page') // Zrzut ekranu strony logowania
                ->assertPathIs('/login')
                ->clickLink('Sign up here')
                ->pause(2000) // Wstrzymaj, aby upewnić się, że strona rejestracji jest załadowana
                ->screenshot($screenshotsDir . '/register_page')
                ->assertPathIs('/register')
                ->type('name', 'New User') // Imię
                ->screenshot($screenshotsDir . '/register_page_name') // Zrzut ekranu po wpisaniu imienia
                ->type('email', 'newuser@example.com') // Email
                ->screenshot($screenshotsDir . '/register_page_email') // Zrzut ekranu po wpisaniu emaila
                ->type('password', 'password123') // Hasło
                ->screenshot($screenshotsDir . '/register_page_password') // Zrzut ekranu po wpisaniu hasła
                ->type('password_confirmation', 'password123') // Potwierdzenie hasła
                ->screenshot($screenshotsDir . '/register_page_password_confirmation') // Zrzut ekranu po wpisaniu potwierdzenia hasła
                ->assertPathIs('/register')
                ->click('.inline-flex.items-center') // Zakładając, że przycisk ma odpowiednią klasę
                ->pause(3000) // Wstrzymaj, aby upewnić się, że proces rejestracji został zakończony
                ->assertPathIs('/verify-email') // Zrzut ekranu po rejestracji
                ->screenshot($screenshotsDir . '/verify-email_page')
                ->assertPathIs('/verify-email'); // Zrzut ekranu po rejestracji
        });
    }
}
