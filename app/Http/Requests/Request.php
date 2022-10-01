<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class Request extends FormRequest
{
    protected function failedValidation(Validator $validator): ValidationException
    {
        $response = new Response(['error' => $validator->errors()], 422);
        throw new ValidationException($validator, $response);
    }
}
