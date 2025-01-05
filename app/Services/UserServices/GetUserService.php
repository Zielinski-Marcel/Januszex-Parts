<?php

namespace App\Services\UserServices;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetUserService
{
    public function getUserByUsername(string $username)
    {
        // Find the user by name
        $user = User::where('name', $username)->first();

        // Return the view with the user
        return $user;
    }
    public function getUserById(int $id)
    {
        $user = User::where('id', $id)->first();
        return $user;
    }

}
