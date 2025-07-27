<?php

namespace App\Presentation\Http\Request\Auth;

use App\Exceptions\InvalidParameterException;
use App\Utils\HttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new InvalidParameterException(
            'Erro de validação: ' . implode(', ', $validator->errors()->all()),
            HttpStatus::UNPROCESSABLE_ENTITY,
            $validator->errors()->toArray()
        );
    }
}
