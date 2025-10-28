<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class StoreUserRequest extends BaseRequest
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
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role_id' => "required|integer|exists:App\Models\Role,id",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'email.required' => 'O campo de e-mail é obrigatório.',
            'password.required' => 'O campo de senha não pode ficar em branco.',
            'c_password.required' => 'O campo de confirme sua senha não pode ficar em branco.',
        ];
    }
}
