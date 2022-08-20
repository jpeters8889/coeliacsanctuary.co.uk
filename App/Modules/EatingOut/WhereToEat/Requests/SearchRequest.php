<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;
use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function resolveSearchTerm(): WhereToEatSearchTerm
    {
        return WhereToEatSearchTerm::query()
            ->where('key', $this->route('term'))
            ->firstOrFail();
    }
}
