<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
class DashboardController extends Controller
{

    public  function show(Request $request)
    {
        $user = $request -> user();
        return Inertia::render("Dashboard",[

            'vehicles' => $user->vehicles,
            'userid' => $user->id,
        ]);
    }

}
