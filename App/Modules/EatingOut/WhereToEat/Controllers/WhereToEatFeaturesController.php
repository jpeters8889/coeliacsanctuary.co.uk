<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

class WhereToEatFeaturesController extends BaseController
{
    public function get(Repository $repository)
    {
        $summary = WhereToEatFeature::query()
            ->orderBy('feature')
            ->get()
            ->mapWithKeys(function ($feature) {
                return [
                    $feature->id => [
                        'id' => $feature->id,
                        'type_id' => $feature->type_id,
                        'label' => $feature->feature,
                        'count' => 0,
                    ],
                ];
            })
            ->toArray();

        $repository
            ->filter()
            ->search()
            ->setWiths(['features'])
            ->all()
            ->each(function (WhereToEat $eatery) use (&$summary) {
                return $eatery->features->each(function ($feature) use (&$summary) {
                    $summary[$feature->id]['count']++;
                });
            });

        return array_values($summary);
    }
}
