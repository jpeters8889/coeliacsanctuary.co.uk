<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EateryFeatureProcessor extends EateryProcessor
{
    public function getEateries(): array
    {
        $features = WhereToEatFeature::query()
            ->orderBy('feature')
            ->get()
            ->mapWithKeys(function (WhereToEatFeature $feature) {
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

        $eateries->each(function (WhereToEat $eatery) use (&$features) {
            $eatery->features->each(function (WhereToEatFeature $feature) use (&$features) {
                $features[$feature->id]['count']++;
            });
        });

        return array_values($features);
    }

    protected function hydrateEateries(Collection $eateryIds, ?Collection $items = null): Collection
    {
        return WhereToEat::query()
            ->with(['features'])
            ->unless(app()->runningUnitTests(), fn (Builder $builder) => $builder->orderByRaw('field(id, ' . $eateryIds->join(',') . ')'))
            ->findMany($eateryIds);
    }
}
