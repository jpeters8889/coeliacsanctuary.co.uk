<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Illuminate\Validation\Rule;
use Coeliac\Base\Requests\ApiFormRequest;

class UpdateDetailsRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user())],
        ];
    }
}
