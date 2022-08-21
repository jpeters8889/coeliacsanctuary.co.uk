<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;

class CuisineField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'exists:wheretoeat_cuisines,id'];
    }

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        return $eatery->cuisine->cuisine;
    }

    public function displaySuggestedValue(): string
    {
        return WhereToEatCuisine::query()->find($this->value)->cuisine;
    }
}
