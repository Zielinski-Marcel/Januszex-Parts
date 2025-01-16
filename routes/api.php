<?php

use App\Http\Controllers\InviteController;
use App\Http\Controllers\SpendingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;



Route::get('/user/{id}', [UserController::class, 'getUser'])->name('getUser');
Route::post('/user', [UserController::class, 'createUser'])->name('createUser');


Route::get('/get/spendings/{vehicle_id}', [SpendingController::class, 'getSpendings'])->name('getSpendings')->middleware('auth.basic');
Route::get('/get/spending/{id}/{vehicle_id}', [SpendingController::class, 'getSpending'])->name('getSpending')->middleware('auth.basic');
Route::post('/create/spending/{vehicle_id}', [SpendingController::class, 'createSpending'])->name('createSpending')->middleware('auth.basic');
Route::post('/edit/spending/{id}/{vehicle_id}', [SpendingController::class, 'editSpending'])->name('editSpending')->middleware('auth.basic');
Route::delete('/deleteuser/spending/{id}/{vehicle_id}', [SpendingController::class, 'deleteSpending'])->name('deleteSpending')->middleware('auth.basic');



Route::get('/getuser/vehicle/{id}', [VehicleController::class, 'getVehicle'])->name('getVehicle')->middleware('auth.basic');
Route::get('/getuser/vehicles', [VehicleController::class, 'getVehicles'])->name('getVehicles')->middleware('auth.basic');
Route::post('/create/vehicle', [VehicleController::class, 'createVehicle'])->name('createVehicle')->middleware('auth.basic');
Route::post('/edit/vehicle/{id}', [VehicleController::class, 'editVehicle'])->name('editVehicle')->middleware('auth.basic');
Route::delete('/deleteuser/vehicle/{id}', [VehicleController::class, 'deleteVehicle'])->name('deleteVehicle')->middleware('auth.basic');

Route::post('/invite', [InviteController::class, 'store'])->name('store')->middleware('auth.basic');
Route::post('/invite/{verification_token}', [InviteController::class, 'update'])->name('update')->middleware('auth.basic');
