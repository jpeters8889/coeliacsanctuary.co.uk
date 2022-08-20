<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\QuickSearchRequest;
use Illuminate\Support\Collection;

class WhereToEatQuickSearchController extends BaseController
{
    public function get(QuickSearchRequest $request): Collection
    {
        $countyResults = WhereToEatCounty::query()
            ->where('county', 'like', "%{$request->input('term')}%")
            ->with('country')
            ->get()
            ->transform(static fn (WhereToEatCounty $county) => [
                'label' => "{$county->county}, {$county->country->country}",
                'url' => "/wheretoeat/{$county->slug}",
            ]);

        $townResults = WhereToEatTown::query()
            ->where('town', 'like', "%{$request->input('term')}%")
            ->with(['county', 'county.country'])
            ->get()
            ->transform(static fn (WhereToEatTown $town) => [
                'label' => "{$town->town}, {$town->county->county}, {$town->county->country->country}",
                'url' => "/wheretoeat/{$town->county->slug}/{$town->slug}",
            ]);

        return (new Collection([...$countyResults->toArray(), ...$townResults->toArray()]))
            ->sortBy('label')
            ->take(10)
            ->values();
    }
}
