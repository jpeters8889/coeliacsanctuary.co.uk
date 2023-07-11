<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EateryRatingsProcessor extends EateryProcessor
{
    public function getEateries(): array
    {
        $ratings = (new Collection([0, 0.5, 1, 1.5, 2, 2.5, 3, 3.5, 4, 4.5, 5]))
            ->mapWithKeys(function ($rating, $index) {
                return [
                    $index => [
                        'id' => $index,
                        'rating' => $rating,
                        'label' => $rating > 0 ? $rating . ' Stars' : 'No Rating',
                        'count' => 0,
                    ],
                ];
            })
            ->reverse()
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

        $eateries->each(function (WhereToEat $eatery) use (&$ratings) {
            $rating = round((float)$eatery->average_rating * 2) / 2;
            $key = $rating * 2;

            $ratings[$key]['count']++;
        });

        return array_values($ratings);
    }

    protected function hydrateEateries(Collection $eateryIds, ?Collection $items = null): Collection
    {
        return WhereToEat::query()
            ->with(['userReviews'])
            ->unless(app()->runningUnitTests(), fn (Builder $builder) => $builder->orderByRaw('field(id, ' . $eateryIds->join(',') . ')'))
            ->findMany($eateryIds);
    }
}
