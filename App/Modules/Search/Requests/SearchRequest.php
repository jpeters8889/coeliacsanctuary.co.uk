<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Search\Models\SearchHistory;

class SearchRequest extends ApiFormRequest
{
    public function rules()
    {
        return [
            'search' => ['required', 'max:50'],
            'areas' => ['required', 'array'],
            'areas.blogs' => ['required', 'bool'],
            'areas.reviews' => ['required', 'bool'],
            'areas.recipes' => ['required', 'bool'],
            'areas.eateries' => ['required', 'bool'],
            'areas.products' => ['required', 'bool'],
        ];
    }

    public function logSearch()
    {
        SearchHistory::query()->create([
            'term' => $this->input('search'),
            'blogs' => $this->input('areas.blogs'),
            'reviews' => $this->input('areas.reviews'),
            'recipes' => $this->input('areas.recipes'),
            'eateries' => $this->input('areas.eateries'),
            'products' => $this->input('areas.products'),
        ]);
    }
}
