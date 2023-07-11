<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors\EaterySummaryProcessor;

class WhereToEatSummaryController extends BaseController
{
    public function get(EaterySummaryProcessor $summaryProcessor): array
    {
        return $summaryProcessor->getEateries();
    }
}
