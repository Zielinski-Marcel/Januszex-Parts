<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/user/{username}', [ProfileController::class, 'show']);


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, "show"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicle']);
Route::post('/create/vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'createVehicle']);
Route::get('/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicle']);

Route::get('/user/{user}/vehicle/create', [\App\Http\Controllers\VehicleController::class, 'create']);
Route::post('/user/{user}/vehicle', [\App\Http\Controllers\VehicleController::class, 'store']);



require __DIR__.'/auth.php';
