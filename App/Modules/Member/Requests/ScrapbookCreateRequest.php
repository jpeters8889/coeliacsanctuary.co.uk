<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class ScrapbookCreateRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
          'name' => ['required'],
        ];
    }
}
