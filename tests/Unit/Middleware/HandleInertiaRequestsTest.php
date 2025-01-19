<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HandleInertiaRequestsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testowanie metody 'version' - sprawdzenie, czy zwraca wersję jako string.
     *
     * @return void
     */
    public function testVersionMethodReturnsCorrectVersion()
    {
        // Tworzymy żądanie
        $request = Request::create('/dashboard');

        // Inicjalizujemy middleware
        $middleware = new HandleInertiaRequests();

        // Uzyskujemy wersję z metody version
        $version = $middleware->version($request);

        // Sprawdzamy, czy wersja jest typu string (powinna to być wersja zasobów)
        $this->assertIsString($version);
    }

    /**
     * Testowanie, czy domyślny widok to 'app'.
     *
     * @return void
     */
    public function testRootViewIsApp()
    {
        // Tworzymy symulowane żądanie
        $request = Request::create('/dashboard');

        // Inicjalizujemy middleware
        $middleware = new HandleInertiaRequests();

        // Sprawdzamy, czy domyślny widok to 'app'
        $this->assertEquals('app', $middleware->rootView($request));
    }

}
