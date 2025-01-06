<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class VehicleController extends Controller
{
    public function getVehicle($id): \Inertia\Response
    {
        $vehicle = Vehicle::where('id', $id)->first();
        return Inertia::render("Dashboard",['vehicle'=>$vehicle]);
    }
    public function createVehicle(CreateVehicleRequest $request): \Inertia\Response
    {

        $vehicle = Vehicle::create($request->all());

        return Inertia::render("Dashboard",[
            'message' => 'Vehicle created successfully.',
            'vehicle' => $vehicle,
        ]);
    }

}
