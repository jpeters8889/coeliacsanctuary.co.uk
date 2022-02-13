<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class UpdatePasswordRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'current' => ['required', 'current_password'],
            'new' => ['required', 'min:8', 'confirmed'],
        ];
    }
}
