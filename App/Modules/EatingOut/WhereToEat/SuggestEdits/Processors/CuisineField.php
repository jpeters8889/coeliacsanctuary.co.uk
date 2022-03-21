<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class CuisineField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'exists:wheretoeat_cuisines,id'];
    }
}
