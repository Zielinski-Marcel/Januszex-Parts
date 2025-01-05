<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class CreateSpendingRequest extends FormRequest
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
            'price' => 'required|numeric|min:0', // Wymagane, liczba, minimalna wartość 0
            'type' => 'required|string|max:255', // Wymagane, ciąg znaków, maksymalnie 255 znaków
            'date' => 'required|date', // Wymagane, poprawna data
            'place' => 'nullable|string|max:255', // Opcjonalne, ciąg znaków, maksymalnie 255 znaków
            'description' => 'nullable|string|max:1000', // Opcjonalne, ciąg znaków, maksymalnie 1000 znaków
            'user_id' => 'required|integer|exists:users,id', // Wymagane, liczba całkowita, musi istnieć w tabeli users w kolumnie id
            'vehicle_id' => 'required|integer|exists:vehicles,id', // Wymagane, liczba całkowita, musi istnieć w tabeli vehicles w kolumnie id
        ];
    }

}
