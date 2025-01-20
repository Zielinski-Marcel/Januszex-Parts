<?php

namespace Database\Factories;

use App\Models\Invite;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invite>
 */
class InviteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invite::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invitor_id' => User::factory(), // Tworzy powiązanego użytkownika jako "invitor"
            'email' => fake()->unique()->safeEmail(),
            'vehicle_id' => Vehicle::factory(), // Tworzy powiązany pojazd
            'status' => 'pending', // Domyślny status zaproszenia
            'verification_token' => Str::random(32), // Losowy token weryfikacyjny
        ];
    }
}
