<?php

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class TravelCardSearchRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'term' => ['required', 'string'],
        ];
    }
}
