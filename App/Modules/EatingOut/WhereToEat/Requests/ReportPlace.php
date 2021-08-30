<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class ReportPlace extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'details' => 'required',
        ];
    }

    public function eatery(): WhereToEat
    {
        return WhereToEat::query()->findOrFail($this->route('id'));
    }
}
