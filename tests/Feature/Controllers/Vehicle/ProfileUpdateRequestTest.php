<?php

namespace Tests\Feature\Controllers\Vehicle;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ProfileUpdateRequestTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_validates_correct_data()
    {
        $user = User::factory()->create(); // Tworzymy przykładowego użytkownika

        // Dane wejściowe, które powinny przejść walidację
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ];

        // Tworzymy reguły walidacji
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // unikamy konfliktu z bieżącym użytkownikiem
        ];

        // Walidacja danych
        $validator = Validator::make($data, $rules);

        // Walidacja powinna przejść
        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_requires_name_and_email()
    {
        $user = User::factory()->create();

        $data = [
            'name' => '', // Brak imienia
            'email' => '', // Brak emaila
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ];

        $validator = Validator::make($data, $rules);

        // Walidacja powinna nie przejść
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_requires_unique_email_except_current_user()
    {
        // Tworzymy dwóch użytkowników z różnymi emailami
        $user1 = User::factory()->create(['email' => 'john.doe@example.com']);
        $user2 = User::factory()->create(['email' => 'jane.doe@example.com']);

        // Dane użytkownika, który próbuje zaktualizować swoje dane, ale używa już istniejącego emaila
        $data = [
            'name' => 'John Doe',
            'email' => 'jane.doe@example.com', // Email innego użytkownika
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user1->id, // pozwalamy na email użytkownika
        ];

        $validator = Validator::make($data, $rules);

        // Walidacja powinna nie przejść
        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_allows_current_email_to_be_unchanged()
    {
        // Tworzymy użytkownika z emailem
        $user = User::factory()->create(['email' => 'john.doe@example.com']);

        // Dane użytkownika, który próbuje zaktualizować swoje dane, ale zachowuje ten sam email
        $data = [
            'name' => 'John Doe Updated',
            'email' => 'john.doe@example.com', // Ten sam email
        ];

        // Reguły walidacji, pozwalamy na ten sam email dla bieżącego użytkownika
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // pozwalamy na ten sam email
        ];

        // Walidacja danych
        $validator = Validator::make($data, $rules);

        // Walidacja powinna przejść, ponieważ email nie został zmieniony
        $this->assertFalse($validator->fails());
    }
}
