<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class InfoField extends Processor
{
    public static function validationRules(): array
    {
        return ['required'];
    }
}
