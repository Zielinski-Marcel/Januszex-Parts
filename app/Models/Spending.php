<?php

namespace App\Models;

use DateTime;

class Spending
{
    private int $id;
    private float $price;
    private DateTime $date;
    private string $type;
    private User $user;
    private string $place;
    private string $description;
    public function __construct(float $price, DateTime $date, string $type, User $user, string $place, string $description){
        $this->price = $price;
        $this->date = $date;
        $this->type = $type;
        $this->user = $user;
        $this->place = $place;
        $this->description = $description;
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }
    public function setType(string $type): void{
        $this->type=$type;
    }
    public function getType(): string{
        return $this->type;
    }
    public function setPlace(string $place): void{
        $this->place=$place;
    }
    public function getPlace(): string{
        return $this->place;
    }
    public function setDescription(string $description): void{
        $this->description=$description;
    }
    public function getDescription(): string{
        return $this->description;
    }

}
