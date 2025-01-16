<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleController;


Route::get('/user/{id}', [UserController::class, 'getUser'])->name('getUser');
Route::post('/user', [UserController::class, 'createUser'])->name('createUser');


Route::get('/get/spendings/{vehicle_id}', [\App\Http\Controllers\Api\SpendingController::class, 'getSpendings'])->name('getSpendings')->middleware('auth.basic');
Route::get('/get/spending/{id}/{vehicle_id}', [\App\Http\Controllers\Api\SpendingController::class, 'getSpending'])->name('getSpending')->middleware('auth.basic');
Route::post('/create/spending/{vehicle_id}', [\App\Http\Controllers\Api\SpendingController::class, 'createSpending'])->name('createSpending')->middleware('auth.basic');
Route::post('/edit/spending/{id}/{vehicle_id}', [\App\Http\Controllers\Api\SpendingController::class, 'editSpending'])->name('editSpending')->middleware('auth.basic');
Route::delete('/deleteuser/spending/{id}/{vehicle_id}', [\App\Http\Controllers\Api\SpendingController::class, 'deleteSpending'])->name('deleteSpending')->middleware('auth.basic');



Route::get('/getuser/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicle'])->name('getVehicle')->middleware('auth.basic');
Route::get('/getuser/vehicles', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicles'])->name('getVehicles')->middleware('auth.basic');
Route::post('/create/vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'createVehicle'])->name('createVehicle')->middleware('auth.basic');
Route::post('/edit/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'editVehicle'])->name('editVehicle')->middleware('auth.basic');
Route::delete('/deleteuser/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'deleteVehicle'])->name('deleteVehicle')->middleware('auth.basic');

Route::post('/invite', [\App\Http\Controllers\Api\InviteController::class, 'store'])->name('store')->middleware('auth.basic');
Route::post('/invite/{verification_token}', [\App\Http\Controllers\Api\InviteController::class, 'update'])->name('update')->middleware('auth.basic');
