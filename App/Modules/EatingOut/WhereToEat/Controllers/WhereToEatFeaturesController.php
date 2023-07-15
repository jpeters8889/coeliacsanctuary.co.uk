<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors\EateryFeatureProcessor;

class WhereToEatFeaturesController extends BaseController
{
    public function get(EateryFeatureProcessor $featureProcessor): array
    {
        return $featureProcessor->getEateries();
    }
}
