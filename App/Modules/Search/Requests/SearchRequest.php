<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class SearchRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'term' => ['required', 'max:50'],
            'areas' => ['required', 'array'],
            'areas.blogs' => ['required', 'bool'],
            'areas.reviews' => ['required', 'bool'],
            'areas.recipes' => ['required', 'bool'],
            'areas.eateries' => ['required', 'bool'],
            'areas.products' => ['required', 'bool'],
        ];
    }
}
