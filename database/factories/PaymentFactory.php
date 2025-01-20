<?php
namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition()
    {
        return [
            'vehicle_id' => Vehicle::factory(),  // Generowanie pojazdu
            'price' => $this->faker->randomFloat(2, 10, 1000),  // Cena płatności
            'date' => $this->faker->date(),  // Data płatności
            'place' => $this->faker->city(),  // Miejsce płatności
            'description' => $this->faker->sentence(),  // Opis płatności
        ];
    }
}
