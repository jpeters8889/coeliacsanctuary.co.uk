<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

class WhereToEatVenueTypesController extends BaseController
{
    public function get(Repository $repository): array
    {
        $summary = WhereToEatVenueType::query()
            ->orderBy('venue_type')
            ->get()
            ->mapWithKeys(function ($venueType) {
                return [
                    $venueType->id => [
                        'id' => $venueType->id,
                        'type_id' => $venueType->type_id,
                        'label' => $venueType->venue_type,
                        'count' => 0,
                    ],
                ];
            })
            ->toArray();

        $repository
            ->filter()
            ->search()
            ->setWiths(['reviews', 'venueType', 'type'])
            ->setColumns(['id', 'type_id', 'venue_type_id'])
            ->all()
            ->each(function (WhereToEat $eatery) use (&$summary) {
                ++$summary[$eatery->venueType->id]['count'];
            });

        return array_values($summary);
    }
}
