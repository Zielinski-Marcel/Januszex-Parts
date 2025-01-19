<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;

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

    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
});

Route::get('/user/{id}', [UserController::class, 'getUser'])->name('getUser');
Route::post('/user', [UserController::class, 'createUser'])->name('createUser');


Route::get('/get/spendings/{vehicle_id}', [\App\Http\Controllers\SpendingController::class, 'getSpendings'])->name('getSpendings')->middleware('auth.basic');
Route::get('/get/spending/{id}/{vehicle_id}', [\App\Http\Controllers\SpendingController::class, 'getSpending'])->name('getSpending')->middleware('auth.basic');
Route::get('/create/spending/{vehicle}', [\App\Http\Controllers\SpendingController::class, 'create'])->middleware('auth.basic');
Route::post('/create/spending/{vehicle_id}', [\App\Http\Controllers\SpendingController::class, 'createSpending'])->name('createSpending')->middleware('auth.basic');
Route::get('/edit/spending/{spending}/', [\App\Http\Controllers\SpendingController::class, 'edit'])->middleware('auth.basic');
Route::put('/edit/spending/{spending}', [\App\Http\Controllers\SpendingController::class, 'editSpending'])->name('editSpending')->middleware('auth.basic');
Route::delete('/deleteuser/spending/{spending}', [\App\Http\Controllers\SpendingController::class, 'deleteSpending'])->name('deleteSpending')->middleware('auth.basic');


Route::get('/getuser/vehicle/{id}', [\App\Http\Controllers\VehicleController::class, 'getVehicle'])->name('getVehicle')->middleware('auth.basic');
Route::get('/getuser/vehicles', [\App\Http\Controllers\VehicleController::class, 'getVehicles'])->name('getVehicles')->middleware('auth.basic');
Route::get('/create/vehicle', [\App\Http\Controllers\VehicleController::class, 'create'])->middleware('auth.basic');
Route::get('/edit/vehicle/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'edit'])->middleware('auth.basic');
Route::post('/create/vehicle', [\App\Http\Controllers\VehicleController::class, 'createVehicle'])->name('createVehicle')->middleware('auth.basic');
Route::post('/edit/vehicle/{id}', [\App\Http\Controllers\VehicleController::class, 'editVehicle'])->name('editVehicle')->middleware('auth.basic');
Route::delete('/deleteuser/vehicle/{id}', [\App\Http\Controllers\VehicleController::class, 'deleteVehicle'])->name('deleteVehicle')->middleware('auth.basic');
Route::delete('/leave/vehicle/{vehicle_id}/{user_id}', [\App\Http\Controllers\VehicleController::class, 'removeUserFromVehicle'])->name('removeUserFromVehicle')->middleware('auth.basic');
Route::delete('/leave/vehicle/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'leaveVehicle'])->name('leaveVehicle')->middleware('auth.basic');

Route::get('/login/redirect',[SocialAuthController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

Route::post('/invite', [InviteController::class, 'store'])->name('store')->middleware('auth.basic');
Route::post('/invite/{verification_token}', [InviteController::class, 'update'])->middleware('auth.basic');
Route::get('/invites', [InviteController::class, 'index'])->middleware('auth.basic');
Route::delete('/invite/{invite}', [InviteController::class, 'destroy'])->middleware('auth.basic');



require __DIR__.'/auth.php';
