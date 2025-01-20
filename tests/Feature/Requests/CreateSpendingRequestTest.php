<?php
namespace Feature\Requests;

use App\Http\Requests\CreateSpendingRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateSpendingRequestTest extends TestCase
{
    #[Test]
    public function test_valid_spending_request()
    {
        $data = [
            'price' => 100,
            'type' => 'Food',
            'date' => '2025-01-20',
            'place' => 'Supermarket',
            'description' => 'Groceries and snacks',
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new CreateSpendingRequest())->rules());

        // Sprawdzamy, czy walidacja nie wykryła żadnych błędów
        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function test_missing_price()
    {
        $data = [
            'type' => 'Food',
            'date' => '2025-01-20',
            'place' => 'Supermarket',
            'description' => 'Groceries and snacks',
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new CreateSpendingRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    #[Test]
    public function test_invalid_price()
    {
        $data = [
            'price' => -10,  // Cena nie może być mniejsza niż 0
            'type' => 'Food',
            'date' => '2025-01-20',
            'place' => 'Supermarket',
            'description' => 'Groceries and snacks',
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new CreateSpendingRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('price', $validator->errors()->toArray());
    }

    #[Test]
    public function test_type_too_long()
    {
        $data = [
            'price' => 100,
            'type' => str_repeat('a', 256), // 256 znaków (przekracza limit 255)
            'date' => '2025-01-20',
            'place' => 'Supermarket',
            'description' => 'Groceries and snacks',
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new CreateSpendingRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('type', $validator->errors()->toArray());
    }

    #[Test]
    public function test_invalid_date_format()
    {
        $data = [
            'price' => 100,
            'type' => 'Food',
            'date' => 'invalid-date',  // Niepoprawny format daty
            'place' => 'Supermarket',
            'description' => 'Groceries and snacks',
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new CreateSpendingRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('date', $validator->errors()->toArray());
    }

    #[Test]
    public function test_missing_type()
    {
        $data = [
            'price' => 100,
            'date' => '2025-01-20',
            'place' => 'Supermarket',
            'description' => 'Groceries and snacks',
        ];

        // Walidujemy dane
        $validator = Validator::make($data, (new CreateSpendingRequest())->rules());

        // Sprawdzamy, czy walidacja nie przeszła
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('type', $validator->errors()->toArray());
    }
}
