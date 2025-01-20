<?php

namespace Database\Factories;

use App\Models\Spending;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpendingFactory extends Factory
{
    protected $model = Spending::class;

    public function definition(): array
    {
        return [
            'price' => $this->faker->randomFloat(2, 1, 1000), // Losowa cena między 1 a 1000 z dwoma miejscami po przecinku
            'date' => $this->faker->dateTimeThisYear(), // Losowa data w bieżącym roku
            'type' => $this->faker->word(), // Losowe słowo jako typ wydatku
            'user_id' => User::factory(), // Tworzenie losowego użytkownika dla user_id
            'vehicle_id' => Vehicle::factory(), // Tworzenie losowego pojazdu dla vehicle_id
            'place' => $this->faker->optional()->city(), // Opcjonalne miasto jako miejsce
            'description' => $this->faker->optional()->sentence(), // Opcjonalny opis
        ];
    }
}

