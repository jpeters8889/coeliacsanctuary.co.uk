<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EaterySummaryProcessor extends EateryProcessor
{
    public function getEateries(): array
    {
        $summary = [
            'total' => 0,
            'eateries' => 0,
            'attractions' => 0,
            'hotels' => 0,
            'reviews' => 0,
        ];

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

        $eateries->each(function (WhereToEat $eatery) use (&$summary) {
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

            if ($eatery->user_reviews_count > 0) {
                ++$summary['reviews'];
            }
        });

        return $summary;
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
