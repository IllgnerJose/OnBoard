<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
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
            "departure_date" => "required|date",
            "return_date" => "required|date",
            "destionation_id" => "required|integer|exists:App\Destionation\User,id",
            "status_id" => "required|integer|exists:App\Models\Status,id",
            "user_id" => "required|integer|exists:App\Models\User,id",
        ];
    }
}
