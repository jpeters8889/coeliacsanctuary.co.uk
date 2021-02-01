<?php

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class LoginRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
          'email' => ['required', 'email'],
          'password' => ['required'],
        ];
    }
}
