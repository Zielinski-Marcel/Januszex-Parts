<?php
namespace Tests\Browser;

use App\Models\User;
use App\Models\Vehicle; // Dodajemy model Vehicle
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\File;

class CreateVehicleTest extends DuskTestCase
{
    use DatabaseMigrations;

    #[Test]
    public function testAddVehicleAndNavigate()
    {
        // Katalog na zrzuty ekranu
        $screenshotsDir = base_path('tests/Browser/screenshots/CreateVehicleTestScreenShots');

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

        // Utwórz pojazd za pomocą fabryki
        $vehicle = Vehicle::factory()->create([
            'owner_id' => $user->id, // Przypisz pojazd do użytkownika
        ]);

        // Uruchom test
        $this->browse(function (Browser $browser) use ($user, $vehicle, $screenshotsDir) {
            // Zaloguj się
            $browser->visit('http://web-CCH/login')
                ->pause(2000)
                ->screenshot($screenshotsDir . '/login_page')
                ->assertPathIs('/login')
                ->type('email', 'test@example.com')
                ->screenshot($screenshotsDir . '/login_page_email')
                ->type('password', 'password123')
                ->screenshot($screenshotsDir . '/login_page_password')
                ->assertPathIs('/login')
                ->waitFor('.inline-flex.items-center', 10)
                ->click('.inline-flex.items-center')
                ->pause(2000)
                ->screenshot($screenshotsDir . '/dashboard_page')
                ->assertPathIs('/dashboard');

            // Kliknij w link do dodawania nowego pojazdu
            $browser->clickLink('Add new vehicle')
                ->pause(2000)
                ->screenshot($screenshotsDir . '/create_vehicle_page')
                ->assertPathIs('/create/vehicle');

            // Wypełnij formularz z danymi pojazdu (dane wygenerowane przez fabrykę)
            $browser->type('brand', $vehicle->brand)
                ->screenshot($screenshotsDir . '/create/vehicle-brand_page')
                ->type('model', $vehicle->model)
                ->screenshot($screenshotsDir . '/create/vehicle-model_page')
                ->type('year_of_manufacture', $vehicle->year_of_manufacture)
                ->screenshot($screenshotsDir . '/create/vehicle-year_page')
                ->type('fuel_type', $vehicle->fuel_type)
                ->screenshot($screenshotsDir . '/create/vehicle-fuel_type_page')
                ->type('purchase_date', $vehicle->purchase_date) // Wypełniamy pole roku zakupu (z fabryki)
                ->screenshot($screenshotsDir . '/create/vehicle-purchase_date_page')
                ->type('color', $vehicle->color) // Wypełniamy pole koloru (z fabryki)
                ->screenshot($screenshotsDir . '/create/vehicle-color_page')
                ->assertPathIs('/create/vehicle');

            // Kliknij przycisk "Dodaj nowy pojazd"
            $browser->click('.w-full.py-2.px-4.border.border-transparent.rounded-md')
                ->pause(2000)
                ->screenshot($screenshotsDir . '/dashboard_after_adding_vehicle')
                ->assertPathIs('/dashboard');
        });

        // Kliknij w dodany pojazd i sprawdź, czy przekierowuje na odpowiednią stronę
        $this->browse(function (Browser $browser) use ($vehicle, $screenshotsDir) {
            $browser->visit('/dashboard')
                ->waitForText($vehicle->brand . ' ' . $vehicle->model, 10) // Czekamy na tekst pojazdu
                ->clickLink($vehicle->brand . ' ' . $vehicle->model) // Klikamy na link pojazdu
                ->pause(2000)
                ->assertPathIs('/dashboard/' . ($vehicle->id+1)) // Używamy dynamicznego ID pojazdu
                ->screenshot($screenshotsDir . '/vehicle_details');
        });
    }
}


