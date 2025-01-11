<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpendingRequest;
use App\Models\Spending;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class SpendingController extends Controller
{
    public function getSpendings($vehicle_id): JsonResponse{
        $user = auth()->user();
        $vehicles = $user->vehicles;
        $vehicle = $vehicles->firstWhere('id', $vehicle_id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or does not belong to the authenticated user.'], 404);
        }

        $spendings = $vehicle->spendings;
        return response()->json(['spending'=>$spendings]);
    }
    public function getSpending($id,$vehicle_id): JsonResponse{
        $user = auth()->user();
        $vehicles = $user->vehicles;
        $vehicle = $vehicles->firstWhere('id', $vehicle_id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or does not belong to the authenticated user.'], 404);
        }
        $spending = $vehicle->spendings->firstWhere('id', $id);
        if (!$spending) {
            return response()->json(['message' => 'Spending not found or does not belong to the authenticated user.'], 404);
        }
        return response()->json(['spending'=>$spending]);
    }

    public function create(Vehicle $vehicle){
        return Inertia::render('Vehicle/AddSpending', ['vehicle' => $vehicle]);
    }

    public function createSpending(CreateSpendingRequest $request,$vehicle_id): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        $vehicles = $user->vehicles;
        $vehicle = $vehicles->firstWhere('id', $vehicle_id);
        if (!$vehicle) {
            abort(404, 'Vehicle not found or does not belong to the authenticated user.');
        }
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['vehicle_id'] = $vehicle['id'];
        $spending = Spending::create($validated);

        // Return a JSON response
        return redirect()->to("/dashboard/" . $vehicle_id);
    }
    public function editSpending($id,CreateSpendingRequest $request,$vehicle_id): JsonResponse
    {
        $user = auth()->user();
        $vehicles = $user->vehicles;
        $vehicle = $vehicles->firstWhere('id', $vehicle_id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or does not belong to the authenticated user.'], 404);
        }
        $spending = $vehicle->spendings->firstWhere('id', $id);
        if (!$spending) {
            return response()->json(['message' => 'Spending not found or does not belong to the authenticated user.'], 404);
        }

        $validated = $request->validated();

        $spending->update($validated);


        return response()->json(['message' => 'Vehicle edited successfully.'], 200);
    }
    public function deleteSpending($id,$vehicle_id): JsonResponse{
        $user = auth()->user();
        $vehicles = $user->vehicles;
        $vehicle = $vehicles->firstWhere('id', $vehicle_id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found or does not belong to the authenticated user.'], 404);
        }
        $spending = $vehicle->spendings->firstWhere('id', $id);
        if (!$spending || $spending(['user_id'])==auth()->id()) {
            return response()->json(['message' => 'Spending not found or does not belong to the authenticated user.'], 404);
        }

        $spending->delete();
        return response()->json(['message' => 'Spending deleted successfully.'], 200);
    }
}
