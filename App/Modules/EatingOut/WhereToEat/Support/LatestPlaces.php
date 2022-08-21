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

    /** @return Collection<int, array{id: int, name: mixed, slug: string, location: string|null, town: string, created_at: string}> */
    public function list(): Collection
    {
        return $this->repository
            ->setWiths(['town', 'county', 'country'])
            ->latest()
            ->take(5)
            ->map(fn (WhereToEat $eatery) => [
                'id' => (int) $eatery->id,
                'name' => $eatery->name,
                'slug' => "/wheretoeat/{$eatery->county->slug}/{$eatery->town->slug}/{$eatery->slug}",
                'location' => $eatery->full_location,
                'town' => "/wheretoeat/{$eatery->county->slug}/{$eatery->town->slug}",
                'created_at' => $eatery->created_at->diffForHumans(),
            ]);
    }
}
