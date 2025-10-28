<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    use ResponseTrait;

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->sendError('Erro de validação.', $validator->errors())
        );
    }
}
