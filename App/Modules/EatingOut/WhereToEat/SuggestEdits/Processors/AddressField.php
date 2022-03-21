<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

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
}
