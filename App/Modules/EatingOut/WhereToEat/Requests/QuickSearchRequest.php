<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class QuickSearchRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
          'term' => ['required', 'alpha_num'],
        ];
    }
}
