<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vehicle\CreateVehicleRequest;
use App\Http\Requests\Vehicle\EditVehicleRequest;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class VehicleController extends Controller
{
    public function getVehicle($id): JsonResponse{
        $user = auth()->user();
        $vehicle = $user->vehicles()
            ->where('vehicles.id', $id)
            ->wherePivot('status', 'active')
            ->first();
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or does not belong to the authenticated user.'], 404);
        }
        return response()->json(['vehicle'=>$vehicle]);
    }
    public function getVehicles(): JsonResponse{
        $user = auth()->user();

        $vehicles = $user->vehicles()->wherePivot('status', 'active');
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
    public function removeUserFromVehicle($vehicle_id, $user_id)
    {
        $vehicle = Vehicle::where('id', $vehicle_id)
            ->where('owner_id', auth()->id())
            ->first();
        if (!$vehicle) {
            dd($vehicle_id);
            abort(404);
        }
        $user=$vehicle->users->where('id', $user_id)->first();
        if (!$user) {
            dd("XDDXDAle drugie");
            abort(404);
        }
        $vehicle->users()->syncWithoutDetaching([
            $user->id => [
                'role' => 'shared',
                'status' => 'inactive',
            ],
        ]);
        return redirect()->back()->with('status', 'User deleted successfully.');
    }

    public function leaveVehicle(Vehicle $vehicle)
    {
        $user = auth()->user();
        if (!$vehicle->users()->where('user_id', $user->id)->exists()) {
            abort(403);
        }

        $vehicle->users()->syncWithoutDetaching([
            $user->id => [
                'role' => 'shared',
                'status' => 'inactive',
            ],
        ]);
        return redirect()->back()->with('status', 'User deleted successfully.');
    }

    public function create(User $user){
        return Inertia::render('Vehicle/AddVehicle', ['userid' => $user -> id]);
    }
    public function edit(Request $request, Vehicle $vehicle): Response
    {
        $user = $request->user();
        if ($vehicle->owner_id!==$user->id) {
            abort(403);
        }
            $userList = $vehicle->users()->wherePivot('status', 'active')->get();
        return Inertia::render('Profile/EditVehicle', [
            'vehicle' => $vehicle,
            'user' => $user,
            'userList' => $userList

        ]);
    }
}
