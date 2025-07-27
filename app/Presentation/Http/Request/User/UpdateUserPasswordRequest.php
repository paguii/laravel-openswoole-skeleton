<?php

namespace App\Presentation\Http\Request\User;

use App\Exceptions\InvalidParameterException;
use App\Utils\HttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new InvalidParameterException(
            'Erro de validação: ' . implode(' ', $validator->errors()->all()), 
            HttpStatus::UNPROCESSABLE_ENTITY
        );
    }
}
