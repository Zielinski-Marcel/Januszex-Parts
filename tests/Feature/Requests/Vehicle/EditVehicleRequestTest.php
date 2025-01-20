<?php
namespace Feature\Requests\Vehicle;
use App\Http\Requests\Vehicle\EditVehicleRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class EditVehicleRequestTest extends TestCase
{
    #[Test]
    public function it_validates_correct_data()
    {
        // Dane, które powinny przejść walidację
        $data = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year_of_manufacture' => 2020,
            'fuel_type' => 'Petrol',
            'purchase_date' => 2020,
            'color' => 'Red',
        ];

        // Walidacja danych przy użyciu reguł z klasy EditVehicleRequest
        $rules = (new EditVehicleRequest())->rules();
        $validator = Validator::make($data, $rules);

        // Walidacja powinna przejść bez błędów
        $this->assertFalse($validator->fails());
    }

    #[Test]
    public function it_requires_all_fields()
    {
        // Brakujące dane w jednym z pól (np. brak brand)
        $data = [
            'model' => 'Corolla',
            'year_of_manufacture' => 2020,
            'fuel_type' => 'Petrol',
            'purchase_date' => 2020,
            'color' => 'Red',
        ];

        $rules = (new EditVehicleRequest())->rules();
        $validator = Validator::make($data, $rules);

        // Walidacja powinna nie przejść, ponieważ 'brand' jest wymagany
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('brand', $validator->errors()->toArray());
    }

    #[Test]
    public function it_validates_year_of_manufacture_is_between_1886_and_current_year()
    {
        // Dane, w których rok produkcji jest niepoprawny (np. 1800)
        $data = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year_of_manufacture' => 1800, // Rok przed 1886
            'fuel_type' => 'Petrol',
            'purchase_date' => 2020,
            'color' => 'Red',
        ];

        $rules = (new EditVehicleRequest())->rules();
        $validator = Validator::make($data, $rules);

        // Walidacja powinna nie przejść, ponieważ rok produkcji jest przed 1886
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('year_of_manufacture', $validator->errors()->toArray());
    }

    #[Test]
    public function it_validates_purchase_date_is_between_1886_and_current_year()
    {
        // Dane, w których data zakupu jest niepoprawna (np. przed 1886)
        $data = [
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year_of_manufacture' => 2020,
            'fuel_type' => 'Petrol',
            'purchase_date' => 1800, // Data przed 1886
            'color' => 'Red',
        ];

        $rules = (new EditVehicleRequest())->rules();
        $validator = Validator::make($data, $rules);

        // Walidacja powinna nie przejść, ponieważ data zakupu jest przed 1886
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('purchase_date', $validator->errors()->toArray());
    }

    #[Test]
    public function it_validates_string_max_length()
    {
        // Dane, w których jedna z właściwości ma zbyt długi ciąg
        $data = [
            'brand' => str_repeat('A', 256), // Zbyt długi brand (więcej niż 255 znaków)
            'model' => 'Corolla',
            'year_of_manufacture' => 2020,
            'fuel_type' => 'Petrol',
            'purchase_date' => 2020,
            'color' => 'Red',
        ];

        $rules = (new EditVehicleRequest())->rules();
        $validator = Validator::make($data, $rules);

        // Walidacja powinna nie przejść, ponieważ długość 'brand' przekracza 255 znaków
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('brand', $validator->errors()->toArray());
    }
}
