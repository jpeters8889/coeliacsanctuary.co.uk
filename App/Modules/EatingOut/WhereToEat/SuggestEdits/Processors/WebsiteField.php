<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class WebsiteField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'url'];
    }
}
