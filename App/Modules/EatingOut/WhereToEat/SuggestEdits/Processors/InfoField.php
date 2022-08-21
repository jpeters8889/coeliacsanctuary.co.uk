<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class InfoField extends Processor
{
    public static function validationRules(): array
    {
        return ['required'];
    }

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        return '';
    }
}
