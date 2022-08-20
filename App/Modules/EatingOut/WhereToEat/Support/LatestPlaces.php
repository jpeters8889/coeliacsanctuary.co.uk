<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Support;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Support\Collection;

class LatestPlaces
{
    public function __construct(protected Repository $repository)
    {
        //
    }

    public function list(): Collection
    {
        return $this->repository
            ->setWiths(['town', 'county', 'country'])
            ->latest()
            ->take(5)
            ->transform(fn (WhereToEat $eatery) => [
                'id' => $eatery->id,
                'name' => $eatery->name,
                'slug' => "/wheretoeat/{$eatery->county->slug}/{$eatery->town->slug}/{$eatery->slug}",
                'location' => $eatery->full_location,
                'town' => "/wheretoeat/{$eatery->county->slug}/{$eatery->town->slug}",
                'created_at' => $eatery->created_at->diffForHumans(),
            ]);
    }
}
