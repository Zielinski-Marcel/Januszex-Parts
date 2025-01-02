<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    public function getVehicle($id): JsonResponse{
        $vehicle = Vehicle::where('id', $id)->first();
        return response()->json(['vehicle'=>$vehicle]);
    }
    public function createVehicle(CreateVehicleRequest $request): JsonResponse
    {

        $vehicle = Vehicle::create($request->all());

        // Return a JSON response
        return response()->json([
            'message' => 'Vehicle created successfully.',
            'vehicle' => $vehicle,
        ], 201); // 201 status code for resource creation
    }

}
