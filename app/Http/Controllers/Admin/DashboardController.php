<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        $admin = auth()->user();
        $users = User::query()->where("is_admin", false)->withCount("vehicles")->get();
        activity()
            ->causedBy(auth()->user())
            ->log('Accessed the admin dashboard.');
        return Inertia::render(
            'Admin/Dashboard',
            ["admin" => $admin, "users" => $users]
        );
    }
}
