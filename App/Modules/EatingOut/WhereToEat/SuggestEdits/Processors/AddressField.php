<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class AddressField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'string'];
    }

    protected function transformFieldValue(): string
    {
        return cs_nl2br($this->value);
    }

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        return $eatery->address;
    }
}
