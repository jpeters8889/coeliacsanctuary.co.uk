<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;

class WhereToEatLatestPlacesController extends BaseController
{
    public function __invoke(Repository $repository)
    {
        return $repository
            ->setWiths(['town', 'county', 'country'])
            ->where('county_id', '>', 1)
            ->latest()
            ->take(5)
            ->transform(fn (WhereToEat $eatery) => [
                'id' => $eatery->id,
                'name' => $eatery->name,
                'location' => $eatery->full_location,
                'created_at' => $eatery->created_at->diffForHumans(),
            ]);
    }
}
