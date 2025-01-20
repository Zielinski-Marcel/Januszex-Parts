<?php


namespace Tests\Browser;

use App\Models\User;

// Import modelu User
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\File;

class LoginFacebookTest extends DuskTestCase
{
    use DatabaseMigrations;


    public function testFacebookLogin()
    {
        // Katalog na zrzuty ekranu
        $screenshotsDir = base_path('tests/Browser/screenshots/LoginFacebookTestScreenShots');


        // Utwórz użytkownika testowego
        $this->artisan('migrate:refresh');

        // Wykonaj test logowania
        $this->browse(function (Browser $browser) use ($screenshotsDir) {
            $browser->visit('http://web-CCH/login') // Odwiedź stronę logowania
            ->pause(3000) // Wstrzymaj ładowanie
            ->screenshot($screenshotsDir . '/login_page'); // Zrzut ekranu strony logowania
            $browser->click('.bg-blue-600') // Zdefiniuj odpowiedni selektor, np. przez 'class' lub 'text'
            ->pause(3000) // Czekaj na przejście do strony Facebooka
            ->screenshot($screenshotsDir . '/facebook-login_page') // Zrzut ekranu strony logowania
            ->assertPathIs('/v3.3/dialog/oauth'); // Sprawdź, czy przekierowało na stronę polityki prywatności
        });
    }
}

