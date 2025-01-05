<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleController;


Route::get('/user/{id}', [UserController::class, 'getUser'])->name('getUser');
Route::post('/user', [UserController::class, 'createUser'])->name('createUser');


Route::get('/get/{id}', [\App\Http\Controllers\Api\SpendingController::class, 'getSpending'])->name('getSpending')->middleware('auth:sanctum');
Route::post('/create/spending', [\App\Http\Controllers\Api\SpendingController::class, 'createSpending'])->name('createSpending')->middleware('auth:sanctum');



Route::get('/getuser/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicle'])->name('getVehicle')->middleware('auth.basic');
Route::get('/getuser/vehicles', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicles'])->name('getVehicles')->middleware('auth.basic');
Route::post('/create/vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'createVehicle'])->name('createVehicle')->middleware('auth.basic');
Route::post('/edit/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'editVehicle'])->name('editVehicle')->middleware('auth.basic');
Route::delete('/deleteuser/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'deleteVehicle'])->name('deleteVehicle')->middleware('auth.basic');
