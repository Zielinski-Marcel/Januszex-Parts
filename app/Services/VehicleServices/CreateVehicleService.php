<?php

namespace App\Services\VehicleServices;
use App\Models\User;
use App\Models\Vehicle;

class CreateVehicleService
{
    public function execute(
        string $name,
        string $model,
        string $brand,
        string $yearOfManufacture,
        string $fuelType,
        User $user
    ): Vehicle {
        return new Vehicle(
            $name,
            $model,
            $brand,
            $yearOfManufacture,
            $fuelType,
            $user
        );
    }
}
