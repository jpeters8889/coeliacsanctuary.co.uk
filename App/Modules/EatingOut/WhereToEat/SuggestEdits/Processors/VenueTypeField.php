<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

class VenueTypeField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'exists:wheretoeat_venue_types,id'];
    }
}
