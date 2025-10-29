<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.unique' => 'Este e-mail já esta em uso.',
            'email.required' => 'O campo de e-mail é obrigatório.',
            'password.required' => 'O campo de senha não pode ficar em branco.',
            'c_password.required' => 'O campo de confirme sua senha não pode ficar em branco.',
            'c_password.same' => 'O campo de confirme sua senha tem que ser igual a sua senha atual.',
        ];
    }
}
