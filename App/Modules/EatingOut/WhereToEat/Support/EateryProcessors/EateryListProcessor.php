<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class EateryListProcessor extends EateryProcessor
{
    public function getEateries(): LengthAwarePaginator
    {
        $paginator = $this->paginateEateryIds();

        $items = collect($paginator->items());

        if ($this->request->has('search')) {
            $items = $this->rawSearchResults()->map(fn (WhereToEat $eatery) => (object)[
                'id' => $eatery->id,
                'type_id' => $eatery->type_id,
                'branch_id' => $eatery->branch?->id ?? null,
            ]);
        }

        $eateryIds = $items->pluck('id');

        /** @var Collection<int, WhereToEat> $eateries */
        $eateries = $this->hydrateEateries($eateryIds, $items);

        $eateries = $this->checkForMissingEateries($eateries, $eateryIds, $items);

        $paginator->through(fn ($item, $index) => $eateries->get($index));

        return $paginator;
    }

    protected function paginateEateryIds(): LengthAwarePaginator
    {
        return $this->eateryBuilder()->paginate((int)$this->request->get('limit', 10));
    }

    protected function serialiseEatery(WhereToEat $eatery, ?int $branchId = null): WhereToEat
    {
        if ($eatery->relationLoaded('userReviews')) {
            /** @phpstan-ignore-next-line */
            $eatery->ratings = $eatery->userReviews;
        }

        $eatery->is_nationwide = $branchId !== null;
        $eatery->unique_key = $eatery->id . ($branchId ? ' - ' . $branchId : null);

        if ($branchId) {
            $eatery->branch = $eatery->branches()
                ->with('town')
                ->find($branchId);
        }

        if (Arr::has($this->getAppends(), $eatery->id)) {
            $eatery->distance = Arr::get($this->getAppends(), $eatery->id . '.distance');
        }

        return $eatery;
    }


    protected function hydrateEateries(Collection $eateryIds, ?Collection $items = null): Collection
    {
        return WhereToEat::query()
            ->with([
                'country', 'county', 'town', 'type', 'venueType', 'cuisine', 'features', 'restaurants',
                'reviews' => function (HasMany $builder) {
                    return $builder
                        ->with(['eatery', 'eatery.town', 'eatery.county', 'eatery.country', 'images'])
                        ->select(['id', 'wheretoeat_id', 'title', 'slug', 'created_at'])
                        ->where('live', 1)
                        ->latest();
                },
                'userReviews' => function (HasMany $builder) {
                    return $builder
                        ->select(['id', 'wheretoeat_id', 'rating', 'name', 'body', 'created_at'])
                        ->where('approved', 1)
                        ->latest();
                },
            ])
            ->unless(app()->runningUnitTests(), fn (Builder $builder) => $builder->orderByRaw('field(id, ' . $eateryIds->join(',') . ')'))
            ->findMany($eateryIds)
            ->map(function (WhereToEat $eatery) use ($items) {
                return $this->serialiseEatery(
                    $eatery,
                    Arr::first($items, fn ($item) => $item->id === $eatery->id)?->branch_id ?? null
                );
            });
    }
}
