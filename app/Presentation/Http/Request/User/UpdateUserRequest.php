<?php

namespace App\Presentation\Http\Request\User;

use App\Exceptions\InvalidParameterException;
use App\Utils\HttpStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255']
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
