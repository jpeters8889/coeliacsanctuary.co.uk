<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Illuminate\Contracts\Auth\Access\Gate;

class ScrapbookUpdateRequest extends ApiFormRequest
{
    public function authorize(Gate $gate): bool
    {
        return $gate->allows('manage-scrapbook', $this->route('scrapbook'));
    }

    public function rules(): array
    {
        return [
          'name' => ['required'],
        ];
    }
}
