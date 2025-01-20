<?php

namespace Feature\Middleware;

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HandleInertiaRequestsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
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

    #[Test]
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
