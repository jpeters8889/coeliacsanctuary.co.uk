<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class SearchCreateRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'text' => ['required'],
            'range' => ['required', 'string', 'in:1,2,5,10,20'],
        ];
    }
}
