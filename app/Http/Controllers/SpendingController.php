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

    public function create(Vehicle $vehicle){
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['vehicle_id' => $vehicle->id])
            ->log('Accessed page to create a new spending.');
        return Inertia::render('Vehicle/AddSpending', ['vehicle' => $vehicle]);
    }

    public function createSpending(CreateSpendingRequest $request,$vehicle_id): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        $vehicle = $user->vehicles()
            ->where('vehicles.id', $vehicle_id)
            ->wherePivot('status', 'active')
            ->first();
        if (!$vehicle) {
            abort(404, 'Vehicle not found or does not belong to the authenticated user.');
        }
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $validated['vehicle_id'] = $vehicle['id'];
        $spending=Spending::create($validated);

        activity()
            ->causedBy($user)
            ->withProperties([
                'spending_id' => $spending->id,
                'vehicle_id' => $vehicle->id,
                'amount' => $spending->amount,
                'description' => $spending->description
            ])
            ->log('Created a new spending.');
        return redirect()->to("/dashboard/" . $vehicle_id)->with('status', 'Added the spending successfully.');
    }

    public function edit(Spending $spending){
        activity()
            ->causedBy(auth()->user())
            ->withProperties([
                'spending_id' => $spending->id,
                'vehicle_id' => $spending->vehicle_id
            ])
            ->log('Accessed page to edit a spending.');
        return Inertia::render('Vehicle/EditSpending', ['spending' => $spending]);
    }

    public function editSpending(CreateSpendingRequest $request, Spending $spending): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $vehicle = $user->vehicles()
            ->where('vehicles.id', $spending->vehicle_id)
            ->wherePivot('status', 'active')
            ->first();
        if ($spending->user_id!==$user->id || !$vehicle) {
            abort(403, 'Spending not found or does not belong to the authenticated user.');
        }

        $validated = $request->validated();
        $spending->update($validated);
        activity()
            ->causedBy($user)
            ->withProperties([
                'spending_id' => $spending->id,
                'vehicle_id' => $spending->vehicle_id,
                'amount' => $spending->amount,
                'description' => $spending->description
            ])
            ->log('Updated a spending.');
        return redirect()->to("/dashboard/" . $spending->vehicle_id)->with('status', 'Edited the spending successfully.');
    }
    public function deleteSpending(Spending $spending): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();
        $vehicle = $user->vehicles()
            ->where('vehicles.id', $spending->vehicle_id)
            ->wherePivot('status', 'active')
            ->first();
        if ($spending->user_id!==$user->id || !$vehicle) {
            abort(403, 'Spending not found or does not belong to the authenticated user.');
        }

        $spending->delete();
        activity()
            ->causedBy($user)
            ->withProperties([
                'spending_id' => $spending->id,
                'vehicle_id' => $spending->vehicle_id
            ])
            ->log('Deleted a spending.');
        return redirect()->back()->with("status", 'Spending deleted successfully.');
    }
}
