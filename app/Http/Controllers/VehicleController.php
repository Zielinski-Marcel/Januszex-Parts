<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicle\CreateVehicleRequest;
use App\Models\User;
use App\Models\Vehicle;
use http\Env\Response;
use Inertia\Inertia;

class VehicleController extends Controller
{
public function store(User $user, CreateVehicleRequest $request)
{
    $vehicle = new Vehicle();
    $vehicle -> fill($request->validated());
    $vehicle -> owner_id = $user -> id;
    $vehicle -> save();
    $user->vehicles()->attach($vehicle->id, [
        'role' => 'owner',
        'status' => 'active'
    ]);
    return redirect()->to("/dashboard");
}
public function create(User $user){
    return Inertia::render('Vehicle/addVehicle', ['userid' => $user -> id]);
}
}
