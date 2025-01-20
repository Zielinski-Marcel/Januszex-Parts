<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\SpendingController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;


Route::get('/user/{username}', [ProfileController::class, 'show']);


Route::redirect('/', '/dashboard');

Route::get('/dashboard/{vehicle?}', [\App\Http\Controllers\DashboardController::class, "show"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('IsUserAdmin')->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');
    Route::get('/admin/logs', [AdminDashboardController::class, 'logs'])->name('logs');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/logs/{user}', [UserController::class, 'userLogs'])->name('admin.users.logs');

});

Route::middleware('auth')->group(function () {
    Route::get('/create/spending/{vehicle}', [SpendingController::class, 'create']);
    Route::post('/create/spending/{vehicle_id}', [SpendingController::class, 'createSpending'])->name('createSpending');
    Route::get('/edit/spending/{spending}/', [SpendingController::class, 'edit']);
    Route::put('/edit/spending/{spending}', [SpendingController::class, 'editSpending'])->name('editSpending');
    Route::delete('/deleteuser/spending/{spending}', [SpendingController::class, 'deleteSpending'])->name('deleteSpending');
});

Route::middleware('auth')->group(function () {
    Route::get('/create/vehicle', [VehicleController::class, 'create']);
    Route::get('/edit/vehicle/{vehicle}', [VehicleController::class, 'edit']);
    Route::post('/create/vehicle', [VehicleController::class, 'createVehicle'])->name('createVehicle');
    Route::patch('/edit/vehicle/{id}', [VehicleController::class, 'editVehicle'])->name('editVehicle');
    Route::delete('/deleteuser/vehicle/{id}', [VehicleController::class, 'deleteVehicle'])->name('deleteVehicle');
    Route::delete('/leave/vehicle/{vehicle_id}/{user_id}', [VehicleController::class, 'removeUserFromVehicle'])->name('removeUserFromVehicle');
    Route::delete('/leave/vehicle/{vehicle}', [VehicleController::class, 'leaveVehicle'])->name('leaveVehicle');
});

Route::middleware('auth')->group(function () {
    Route::post('/invite', [InviteController::class, 'store'])->name('store');
    Route::post('/invite/{verification_token}', [InviteController::class, 'update']);
    Route::get('/invites', [InviteController::class, 'index']);
    Route::delete('/invite/{invite}', [InviteController::class, 'destroy']);
});

Route::get('/login/redirect',[SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);



require __DIR__.'/auth.php';
