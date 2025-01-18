<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Testowanie strony logowania.
     *
     * @return void
     */
    public function testLoginPageScreenshot()
    {
        $this->browse(function (Browser $browser) {
            // Odwiedzamy stronę logowania
            $browser->visit('http://web-CCH/login')
                ->pause(2000)  // Czekamy na załadowanie strony
                ->screenshot('login_page_before_load');  // Zrzut ekranu przed załadowaniem zasobów

            // Może dodasz kolejny zrzut po załadowaniu strony?
            $browser->pause(5000)  // Czekamy dłużej, aby upewnić się, że strona jest w pełni załadowana
            ->screenshot('login_page_after_load');  // Zrzut ekranu po pełnym załadowaniu
        });
    }
}
