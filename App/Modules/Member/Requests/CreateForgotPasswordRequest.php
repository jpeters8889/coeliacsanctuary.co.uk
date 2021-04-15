<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class CreateForgotPasswordRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
