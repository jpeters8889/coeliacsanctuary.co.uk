<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class GfMenuLinkField extends Processor
{
    public static function validationRules(): array
    {
        return ['required', 'url'];
    }

    public function computeCurrentValue(WhereToEat $eatery): string|null
    {
        return $eatery->gf_menu_link;
    }
}
