<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition()
    {
        return [
            'brand' => $this->faker->company(), // Generuje nazwę firmy jako markę pojazdu
            'model' => $this->faker->word(), // Generuje losowy model pojazdu
            'year_of_manufacture' => $this->faker->year(), // Generuje losowy rok produkcji
            'fuel_type' => $this->faker->randomElement(['Petrol', 'Diesel', 'Electric', 'Hybrid']), // Generuje losowy typ paliwa
            'purchase_date' => $this->faker->year(), // Generuje losowy rok zakupu
            'color' => $this->faker->safeColorName(), // Generuje losowy kolor pojazdu
            'owner_id' => User::factory(), // Tworzy losowego użytkownika, który zostanie przypisany jako właściciel
        ];
    }
}
