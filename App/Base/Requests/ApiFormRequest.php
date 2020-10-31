<?php

declare(strict_types=1);

namespace Coeliac\Base\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): void
    {
        $jsonResponse = response()->json(['errors' => $validator->errors()], 422);

        throw new HttpResponseException($jsonResponse);
    }
}
