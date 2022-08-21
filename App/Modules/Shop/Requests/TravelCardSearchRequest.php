<?php

declare(strict_types=1);

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
