<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserVehicleFactory extends Factory
{
    /**
     * Definicja modelu dla fabryki.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Tworzy nowego użytkownika
            'vehicle_id' => Vehicle::factory(), // Tworzy nowy pojazd
            'role' => $this->faker->randomElement(['owner', 'shared']), // Losowa rola
            'status' => $this->faker->randomElement(['pending', 'accepted', 'rejected']), // Losowy status
        ];
    }
}
