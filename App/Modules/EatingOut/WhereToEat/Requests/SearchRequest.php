<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;

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
