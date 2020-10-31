<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatSummaryController extends BaseController
{
    public function get(Repository $repository)
    {
        $summary = [
            'total' => 0,
            'eateries' => 0,
            'attractions' => 0,
            'hotels' => 0,
            'reviews' => 0,
        ];

        $repository
            ->filter()
            ->search()
            ->setWiths(['venueType'])
            ->setWithCounts(['reviews'])
            ->setColumns(['id', 'type_id', 'venue_type_id'])
            ->all()
            ->each(function (WhereToEat $eatery) use (&$summary) {
                ++$summary['total'];

                if ($eatery->type_id === 1) {
                    ++$summary['eateries'];
                }

                if ($eatery->type_id === 2) {
                    ++$summary['attractions'];
                }

                if ($eatery->type_id === 3) {
                    ++$summary['hotels'];
                }

                if ($eatery->review_count > 0) {
                    ++$summary['reviews'];
                }
            });

        return $summary;
    }
}
