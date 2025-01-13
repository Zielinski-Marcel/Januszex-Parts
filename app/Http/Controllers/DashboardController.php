<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
class DashboardController extends Controller
{

    public  function show(Request $request ,?Vehicle $vehicle=null)
    {
        $spendings = [];
        if($vehicle !== null){
            $spendings = $vehicle->spendings;
        }
        $user = $request -> user();
        return Inertia::render("Dashboard",[
            'spendings' => $spendings,
            'vehicles' => $user->vehicles,
            'vehicle' => $vehicle,
            'userid' => $user->id,
        ]);

    }

}
