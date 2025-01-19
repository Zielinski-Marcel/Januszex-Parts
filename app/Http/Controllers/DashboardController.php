<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;
class DashboardController extends Controller
{

    public  function show(Request $request ,?Vehicle $vehicle=null)
    {
        $user = $request -> user();
        $spendings = $user->lastSpendings();
        if($vehicle !== null){
            $spendings = $vehicle->spendings()->with(["user", "vehicle"])->get();
        }

        $coowners = $spendings->pluck("user.name", "user.name")->unique()->toArray();
        $spendingsTypes = $spendings->pluck("type", "type")->unique()->toArray();
        activity()
            ->causedBy($user)
            ->withProperties(['action' => 'Viewed dashboard'])
            ->log('User accessed '. ($vehicle ? $vehicle->brand : '') .' dashboard');
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
