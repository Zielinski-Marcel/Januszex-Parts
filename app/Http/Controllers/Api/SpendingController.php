<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSpendingRequest;
use App\Models\Spending;
use Illuminate\Http\JsonResponse;

class SpendingController extends Controller
{
    public function getSpendings($id): JsonResponse{
        $spending = Spending::where('id', $id)->first();
        return response()->json(['spending'=>$spending]);
    }

    public function createSpending(CreateSpendingRequest $request): JsonResponse
    {

        $spending = Spending::create($request->all());

        // Return a JSON response
        return response()->json([
            'message' => 'Spending created successfully.',
            'spending' => $spending,
        ], 201); // 201 status code for resource creation
    }
}
