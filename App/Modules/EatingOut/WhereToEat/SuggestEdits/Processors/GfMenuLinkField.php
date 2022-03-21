<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class GfMenuLinkField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'url'];
    }
}
