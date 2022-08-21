<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

class VenueTypeField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'exists:wheretoeat_venue_types,id'];
    }

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        return $eatery->venueType->venue_type;
    }

    public function displaySuggestedValue(): string
    {
        return WhereToEatVenueType::query()->find($this->value)->venue_type;
    }
}
