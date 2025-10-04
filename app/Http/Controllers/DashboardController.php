<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
class DashboardController extends Controller
{

    public  function show(Request $request)
    {
        $user = $request -> user();

        activity()
            ->causedBy($user)
            ->withProperties(['action' => 'Viewed dashboard'])
            ->log('User accessed   dashboard');
        return Inertia::render("Dashboard",[
            'userid' => $user->id,
        ]);
    }
}
