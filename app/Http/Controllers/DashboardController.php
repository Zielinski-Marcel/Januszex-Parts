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
        $user = $request -> user();
        $spendings = $user->lastSpendings();
        if($vehicle !== null){
            $spendings = $vehicle->spendings()->with(["user", "vehicle"])->get();
        }

        $coowners = $spendings->pluck("user.name")->unique()->toArray();
        $spendingsTypes = $spendings->pluck("type")->unique()->toArray();

        return Inertia::render("Dashboard",[
            'spendings' => $spendings,
            'vehicles' => $user->vehicles()->wherePivot('status', 'active')->get(),
            'vehicle' => $vehicle,
            'userid' => $user->id,
            'coowners' => $coowners,
            'spendingsTypes' => $spendingsTypes,
        ]);
    }
}
