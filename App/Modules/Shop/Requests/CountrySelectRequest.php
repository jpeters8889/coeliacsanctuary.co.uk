<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class CountrySelectRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'country' => ['required', 'numeric', 'exists:shop_postage_countries,id'],
        ];
    }
}
