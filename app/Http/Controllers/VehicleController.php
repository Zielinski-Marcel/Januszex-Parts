<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\CreateVehicleRequest;
use App\Http\Requests\Vehicle\EditVehicleRequest;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;


class VehicleController extends Controller
{
    public function getVehicle($id): JsonResponse{
        $user = auth()->user();

        $vehicles = $user->vehicles;
        $vehicle = $vehicles->firstWhere('id', $id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or does not belong to the authenticated user.'], 404);
        }
        return response()->json(['vehicle'=>$vehicle]);
    }
    public function getVehicles(): JsonResponse{
        $user = auth()->user();

        $vehicles = $user->vehicles;
        return response()->json([
            'vehicles' => $vehicles
        ], 200);
    }
    public function createVehicle(CreateVehicleRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $validated = $request->validated();
        $vehicle = new Vehicle();
        $vehicle -> fill($validated);
        $vehicle -> user() -> associate($user);
        $vehicle -> save();
        $user->vehicles()->attach($vehicle->id, [
            'role' => 'owner',
            'status' => 'active'
        ]);
        return redirect()->to("/dashboard");
    }
    public function editVehicle(EditVehicleRequest $request, $id): JsonResponse
    {
        $vehicle = Vehicle::where('id', $id)
            ->where('owner_id', auth()->id())
            ->first();

        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or unauthorized'], 404);
        }

        $validated = $request->validated();

        $vehicle->update($validated);


        return response()->json(['message' => 'Vehicle edited successfully.'], 200);
    }

    public function deleteVehicle($id): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $vehicle = Vehicle::where('id', $id)
            ->where('owner_id', auth()->id())
            ->first();

        if (!$vehicle) {
            abort(404);
        }
        $vehicle->delete();
        return redirect()->back()->with('status', 'Vehicle deleted successfully.');
    }

    public function create(User $user){
        return Inertia::render('Vehicle/addVehicle', ['userid' => $user -> id]);
    }
}
