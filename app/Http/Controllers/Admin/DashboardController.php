<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        activity()
            ->causedBy(auth()->user())
            ->log('Accessed the admin dashboard.');

        return view('admin.dashboard.blade.php');
    }
}
