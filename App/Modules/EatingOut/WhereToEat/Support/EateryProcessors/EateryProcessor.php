<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors;

use Coeliac\Common\Filters\AbstractFilter;
use Coeliac\Modules\EatingOut\WhereToEat\Filters\WhereToEatNationwideFilter;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class EateryProcessor
{
    /** @var Repository[] */
    protected array $repositories = [];

    public function __construct(protected Request $request)
    {
        //
    }

    abstract protected function hydrateEateries(Collection $eateryIds, ?Collection $items = null): Collection;

    abstract public function getEateries();

    public function getAppends(): array
    {
        return Arr::last($this->repositories)->getAppends();
    }

    protected function checkForMissingEateries(Collection $eateries, Collection $eateryIds, Collection $items): Collection
    {
        if ($eateries->count() === $eateryIds->count()) {
            return $eateries;
        }

        $eateryIds->each(function ($id, $index) use (&$eateries, $items) {
            if ($eateries->get($index)?->id === $id) {
                return;
            }

            $duplicateEatery = clone $eateries->firstWhere('id', $id);

            $duplicateEatery = $this->serialiseEatery($duplicateEatery, $items[$index]->branch_id);

            $oldEateries = clone $eateries;

            $eateries = $oldEateries->take($index);
            $eateries->push($duplicateEatery);
            $eateries->push(...$oldEateries->skip($index)->all());
        });

        return $eateries;
    }

    protected function serialiseEatery(WhereToEat $eatery, ?int $branchId = null): WhereToEat
    {
        return $eatery;
    }

    protected function eateryBuilder(): QueryBuilder
    {
        return $this->getQuery()
            ->toBase()
            ->addSelect([
                'wheretoeat.name as ordering',
                'type_id',
                DB::raw('null as branch_id'),
            ])
            ->unless(
                $this->request->has('search'),
                fn (QueryBuilder $builder) => $builder
                ->unionAll(
                    $this->getQuery(WhereToEatNationwideFilter::class)
                    ->toBase()
                    ->reorder()
                    ->leftJoin(
                        'wheretoeat_nationwide_branches',
                        'wheretoeat.id',
                        'wheretoeat_nationwide_branches.wheretoeat_id',
                    )
                    ->where('wheretoeat_nationwide_branches.live', true)
                    ->addSelect([
                        !app()->runningUnitTests() ? DB::raw('if(wheretoeat_nationwide_branches.name, concat(wheretoeat_nationwide_branches.name, " ", wheretoeat.name), concat(wheretoeat.name, " ", wheretoeat_nationwide_branches.id)) as ordering') : 'wheretoeat_nationwide_branches.name',
                        'type_id',
                        'wheretoeat_nationwide_branches.id as branch_id',
                    ])
                )
            )
            ->when(
                $this->request->has('search') && !app()->runningUnitTests(),
                fn (QueryBuilder $builder) => $builder->orderByRaw('field(wheretoeat.id, ' . $this->rawSearchResults()->pluck('id')->join(',') . ')'),
                fn (QueryBuilder $builder) => $builder->orderBy('ordering')
            );
    }

    /** @param class-string<AbstractFilter> $filterClass */
    protected function getQuery(?string $filterClass = null): Repository
    {
        $repository = app(Repository::class);

        $this->repositories[] = $repository;

        return $repository
            ->filter($filterClass)
            ->search()
            ->setColumns(['wheretoeat.id']);
    }

    /** @return Collection<WhereToEat> $results */
    protected function rawSearchResults(): Collection
    {
        return $this->repositories[0]->rawSearchResults();
    }
}
