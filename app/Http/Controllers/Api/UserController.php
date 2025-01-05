<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;


class UserController extends Controller
{
    public function getUser($id): JsonResponse{
        $user = User::where('id', $id)->first();
        return response()->json(['user'=>$user]);
    }
    public function createUser(): JsonResponse{
        return response()->json([]);
    }

}
