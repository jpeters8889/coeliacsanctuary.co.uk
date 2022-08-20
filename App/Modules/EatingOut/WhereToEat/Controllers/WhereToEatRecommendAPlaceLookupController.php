<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\RecommendAPlaceLookupRequest;

class WhereToEatRecommendAPlaceLookupController extends BaseController
{
    public function __invoke(RecommendAPlaceLookupRequest $request): array
    {
        return [
            'results' => WhereToEat::query()
                ->with(['town', 'county', 'country'])
                ->where('live', 1)
                ->where('name', 'like', "%{$request->input('term')}%")
                ->orderBy('name')
                ->get()
                ->transform(fn (WhereToEat $eatery) => [
                    'name' => $eatery->name,
                    'location' => $eatery->full_location,
                ]),
        ];
    }
}
