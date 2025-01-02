<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year_of_manufacture' => 'required|integer|min:1886|max:' . date('Y'),
            'fuel_type' => 'required|string|max:50',
            'purchase_date' => 'required|integer|min:1886|max:' . date('Y'),
            'color' => 'required|string|max:255',
        ];
    }
}
