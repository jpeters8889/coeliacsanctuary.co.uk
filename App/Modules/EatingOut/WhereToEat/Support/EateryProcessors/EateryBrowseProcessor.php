<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Common\Filters\AbstractFilter;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class EateryBrowseProcessor extends EateryProcessor
{
    public function getEateries()
    {
        $items = $this->eateryBuilder()->get();

        $eateryIds = $items->pluck('id');

        /** @var Collection<int, WhereToEat> $eateries */
        $eateries = $this->hydrateEateries($eateryIds, $items);

        $eateries = $this->checkForMissingEateries($eateries, $eateryIds, $items);

        return $eateries;
    }

    protected function hydrateEateries(Collection $eateryIds, ?Collection $items = null): Collection
    {
        return WhereToEat::query()
            ->unless(app()->runningUnitTests(), fn (Builder $builder) => $builder->orderByRaw('field(id, ' . $eateryIds->join(',') . ')'))
            ->findMany($eateryIds)
            ->map(function (WhereToEat $eatery) use ($items) {
                return $this->serialiseEatery(
                    $eatery,
                    Arr::first($items, fn ($item) => $item->id === $eatery->id)?->branch_id ?? null
                );
            });
    }

    protected function serialiseEatery(WhereToEat $eatery, ?int $branchId = null): WhereToEat
    {
        $branch = null;

        if ($branchId) {
            $branch = $eatery->branches()
                ->with('town')
                ->find($branchId);
        }

        return $eatery->newInstance([
            "id" => $eatery->id,
            'branch_id' => $branch?->id,
            "lat" => $branch ? $branch->lat : $eatery->lat,
            "lng" => $branch ? $branch->lng : $eatery->lng,
            "name" => $branch ? "{$branch->name} - {$eatery->name}" : $eatery->name,
            "distance" => Arr::get($this->getAppends(), $eatery->id . '.distance'),
        ]);
    }

    /** @param class-string<AbstractFilter> $filterClass */
    protected function getQuery(?string $filterClass = null): Repository
    {
        $prefix = $filterClass === null ? 'wheretoeat' : 'wheretoeat_nationwide_branches';

        $repository = app(Repository::class);

        $this->repositories[] = $repository;

        return $repository
            ->selectRaw("(
                        3959 * acos (
                          cos ( radians(?) )
                          * cos( radians( {$prefix}.lat ) )
                          * cos( radians( {$prefix}.lng ) - radians(?) )
                          + sin ( radians(?) )
                          * sin( radians( {$prefix}.lat ) )
                        )
                      ) AS distance", [
                $this->request->get('lat'),
                $this->request->get('lng'),
                $this->request->get('lat'),
            ])
            ->when(
                !app()->runningUnitTests(),
                fn (Builder $builder) => $builder->having('distance', '<=', $this->request->get('range'))
            )
            ->filter($filterClass)
            ->setColumns(['wheretoeat.id']);
    }
}
