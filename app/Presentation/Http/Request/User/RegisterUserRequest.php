<?php

namespace App\Presentation\Http\Request\User;

use App\Exceptions\InvalidParameterException;
use App\Utils\HttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'last_name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:50'],
            'password_confirmation' => ['required', 'same:password'],
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
