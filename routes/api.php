<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleController;


Route::post('/{user}', [UserController::class, 'changeUserName']);



Route::get('/user/{id}', [UserController::class, 'getUser']);
//Route::post('/user', [UserController::class, 'createUser']);


Route::get('/spending/{id}', [\App\Http\Controllers\Api\SpendingController::class, 'getSpending']);
Route::post('/create/spending', [\App\Http\Controllers\Api\SpendingController::class, 'createSpending']);


Route::get('/vehicle/{id}', [\App\Http\Controllers\Api\VehicleController::class, 'getVehicle']);
Route::post('/create/vehicle', [\App\Http\Controllers\Api\VehicleController::class, 'createVehicle']);
