<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Support\LatestPlaces;

class WhereToEatLatestPlacesController extends BaseController
{
    public function __invoke(LatestPlaces $latestPlaces)
    {
        return $latestPlaces->list();
    }
}
