<?php
namespace Tests\Feature\Http\Requests\Invite;

use App\Models\User;
use App\Models\Vehicle;
use App\Http\Requests\Invite\StoreInviteRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreInviteRequestTest extends TestCase
{
    #[Test]
    public function test_valid_invite_request()
    {
        // Tworzymy pojazd w bazie danych
        $vehicle = Vehicle::factory()->create();

        // Tworzymy poprawne dane
        $data = [
            'email' => 'test@example.com',
            'vehicle_id' => $vehicle->id,
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new StoreInviteRequest())->rules());

        // Sprawdzamy, czy nie ma żadnych błędów walidacji
        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function test_missing_email()
    {
        // Tworzymy pojazd w bazie danych
        $vehicle = Vehicle::factory()->create();

        // Brak e-maila w danych
        $data = [
            'vehicle_id' => $vehicle->id,
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new StoreInviteRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    #[Test]
    public function test_invalid_email_format()
    {
        // Tworzymy pojazd w bazie danych
        $vehicle = Vehicle::factory()->create();

        // Niepoprawny format e-maila
        $data = [
            'email' => 'invalid-email',
            'vehicle_id' => $vehicle->id,
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new StoreInviteRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
    }

    #[Test]
    public function test_invalid_vehicle_id()
    {
        // Tworzymy poprawny e-mail
        $data = [
            'email' => 'test@example.com',
            'vehicle_id' => 999999, // Zakładając, że takie `vehicle_id` nie istnieje
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new StoreInviteRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('vehicle_id', $validator->errors()->toArray());
    }
}
