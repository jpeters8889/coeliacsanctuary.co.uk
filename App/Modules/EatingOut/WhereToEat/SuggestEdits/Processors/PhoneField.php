<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class PhoneField extends Processor
{
    public static function validationRules(): array
    {
        return ['required'];
    }
}
