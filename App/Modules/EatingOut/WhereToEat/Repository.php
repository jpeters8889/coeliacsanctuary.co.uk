<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\EatingOut\WhereToEat\Models\NationwideBranch;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as BaseCollection;
use RuntimeException;
use Spatie\Geocoder\Geocoder;

/** @extends AbstractRepository<WhereToEat> */
class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected array $appends = [];

    protected string|array $orderByColumn = 'name';

    /** @var BaseCollection<WhereToEat> */
    protected BaseCollection $rawSearchResults;

    public function getAppends(): array
    {
        return $this->appends;
    }

    /** @return class-string<BaseModel<WhereToEat>> */
    protected function model(): string
    {
        return WhereToEat::class;
    }

    protected function resolveLatLng(array $parameters): array
    {
        if (array_key_exists('lat', $parameters) && array_key_exists('lng', $parameters)) {
            return [
                'lat' => $parameters['lat'],
                'lng' => $parameters['lng'],
            ];
        }

        if (array_key_exists('term', $parameters)) {
            $geocoder = Container::getInstance()
                ->make(Geocoder::class)
                ?->getCoordinatesForAddress($parameters['term']);

            return [
                'lat' => $geocoder['lat'],
                'lng' => $geocoder['lng'],
            ];
        }

        throw new RuntimeException('No search parameters');
    }

    /** @param class-string<WhereToEat> $model */
    protected function performSearch(string $model): array|null
    {
        if (!$this->useSearch) {
            return null;
        }

        /** @var Request $request */
        $request = Container::getInstance()->make(Request::class);

        if ($request->has('search')) {
            $parameters = json_decode($request->get('search'), true);

            $params = [ //@phpstan-ignore-line
                'aroundLatLng' => implode(', ', $latlng = $this->resolveLatLng((array)array_filter($parameters))),
                'aroundRadius' => (int)round(((int)$parameters['range']) * 1609.344),
                'getRankingInfo' => true,
            ];

            /** @var Collection<WhereToEat> $eateryResults */
            $eateryResults = $model::search()->with($params)->get();

            /** @var Collection<WhereToEat> $results */
            $branchResults = NationwideBranch::search()->with($params)->get()
                ->load('eatery')
                ->map(function (NationwideBranch $branch) {
                    $eatery = clone $branch->eatery;
                    $eatery->branch = $branch;
                    $eatery->withScoutMetadata('_rankingInfo', $branch->scoutMetadata()['_rankingInfo']);

                    return $eatery;
                });

            $results = collect([...$eateryResults, ...$branchResults]);

            $results = $results->reject(fn (WhereToEat $whereToEat) => $whereToEat->county_id === 1 && $whereToEat->branches_count === 0)
                ->each(function ($result) {
                    if (isset($result->scoutMetadata()['_rankingInfo']['geoDistance'])) {
                        $distance = round($result->scoutMetadata()['_rankingInfo']['geoDistance'] / 1609, 1);

                        $result->distance = $distance;

                        $this->appends[$result->id] = [
                            'distance' => $distance,
                        ];
                    }
                })
                ->sortBy('distance')
                ->values();

            $this->rawSearchResults = $results;

            $this->appends['latlng'] = $latlng;

            abort_if($results->count() === 0, 404);

            return $results->pluck(['id'])->toArray();
        }

        return null;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('wheretoeat.live', true);
    }

    protected function order(Builder $builder): void
    {
        $params = $this->orderByColumn;

        if (is_string($params)) {
            $params = [$params, 'asc'];
        }

        $builder->orderBy(...$params);
    }

    public function latest(): self
    {
        $this->orderByColumn = ['created_at', 'desc'];

        return $this;
    }

    /** @return BaseCollection<WhereToEat> */
    public function rawSearchResults(): BaseCollection
    {
        return $this->rawSearchResults;
    }
}
