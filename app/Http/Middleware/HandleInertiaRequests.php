<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            "flash" => $this->getFlashData($request),
            'auth' => [
                'user' => $request->user(),
            ],
        ];
    }

    protected function getFlashData(Request $request): Closure
    {
        return fn(): array => [
            "status" => $request->session()->get("status"),
        ];
    }
}
