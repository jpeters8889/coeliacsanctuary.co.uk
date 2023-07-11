<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EateryVenueTypeProcessor extends EateryProcessor
{
    public function getEateries(): array
    {
        $venueTypes = WhereToEatVenueType::query()
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

        $items = $this->eateryBuilder()->get();

        if ($this->request->has('search')) {
            $items = $this->rawSearchResults()->map(fn (WhereToEat $eatery) => (object)[
                'id' => $eatery->id,
                'type_id' => $eatery->type_id,
                'branch_id' => $eatery->branch?->id ?? null,
            ]);
        }

        $eateryIds = $items->pluck('id');

        /** @var Collection<int, WhereToEat> $eateries */
        $eateries = $this->hydrateEateries($eateryIds);

        $eateries = $this->checkForMissingEateries($eateries, $eateryIds, $items);

        $eateries->each(function (WhereToEat $eatery) use (&$venueTypes) {
            ++$venueTypes[$eatery->venueType->id]['count'];
        });

        return array_values($venueTypes);
    }

    protected function hydrateEateries(Collection $eateryIds, ?Collection $items = null): Collection
    {
        return WhereToEat::query()
            ->with(['venueType'])
            ->withCount(['userReviews'])
            ->unless(app()->runningUnitTests(), fn (Builder $builder) => $builder->orderByRaw('field(id, ' . $eateryIds->join(',') . ')'))
            ->findMany($eateryIds);
    }
}
