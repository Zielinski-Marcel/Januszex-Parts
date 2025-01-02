<?php

namespace App\Models;

class Vehicle
{
    private $id;
    private $name;
    private $model;
    private $brand;
    private $yearOfManufacture;
    private $fuelType;
    private array $listOfSpendings=[];
    private array $listOfVehicleUsers=[];
    public function __construct(string $name, string $model, string $brand, string $yearOfManufacture, string $fuelType, User $user){
        $this->name = $name;
        $this->model = $model;
        $this->brand = $brand;
        $this->yearOfManufacture = $yearOfManufacture;
        $this->fuelType = $fuelType;
        $this->listOfVehicleUsers[] = $user;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }
    public function getBrand(): string
    {
        return $this->brand;
    }
    public function setModel(string $model): void
    {
        $this->model = $model;
    }
    public function getModel(): string{
        return $this->model;
    }
    public function setYearOfManufacture(string $yearOfManufacture): void
    {
        $this->yearOfManufacture = $yearOfManufacture;
    }
    public function getYearOfManufacture(): string{
        return $this->yearOfManufacture;
    }
    public function setFuelType(string $fuelType): void
    {
        $this->fuelType = $fuelType;
    }
    public function getFuelType(): string
    {
        return $this->fuelType;
    }
    public function addSpending(Spending $spending): void
    {
        $this->listOfSpendings[] = $spending;
    }
    public function addUser(User $user): void
    {
        $this->listOfVehicleUsers[] = $user;
    }
    public function getListOfSpendings(): array{
        return $this->listOfSpendings;
    }
    public function getListOfVehicleUsers(): array{
        return $this->listOfVehicleUsers;
    }
}
