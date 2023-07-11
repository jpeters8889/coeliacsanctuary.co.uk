<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors\EateryVenueTypeProcessor;

class WhereToEatVenueTypesController extends BaseController
{
    public function get(EateryVenueTypeProcessor $venueTypeProcessor): array
    {
        return $venueTypeProcessor->getEateries();
    }
}
