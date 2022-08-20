<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use RuntimeException;
use Spatie\Geocoder\Geocoder;

/** @extends AbstractRepository<WhereToEat> */
class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected array $appends = [];

    protected string|array $orderByColumn = 'name';

    public function getAppends(): array
    {
        return $this->appends;
    }

    /** @return class-string<BaseModel<WhereToEat>> */
    protected function model(): string
    {
        return WhereToEat::class; //@phpstan-ignore-line
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
        if (! $this->useSearch) {
            return null;
        }

        /** @var Request $request */
        $request = Container::getInstance()->make(Request::class);

        if ($request->has('search')) {
            $parameters = json_decode($request->get('search'), true);

            $results = $model::search()->with([ //@phpstan-ignore-line
                    'aroundLatLng' => implode(', ', $latlng = $this->resolveLatLng((array)array_filter($parameters))),
                    'aroundRadius' => (int)round(((int)$parameters['range']) * 1609.344),
                    'getRankingInfo' => true,
                ])
                ->get();

            $results = $results->reject(fn (WhereToEat $whereToEat) => $whereToEat->county_id === 1)
                ->each(function ($result) {
                    if (isset($result->scoutMetadata()['_rankingInfo']['geoDistance'])) {
                        $this->appends[$result->id] = [
                            'distance' => round($result->scoutMetadata()['_rankingInfo']['geoDistance'] / 1609, 1),
                        ];
                    }
                });

            $this->appends['latlng'] = $latlng;

            abort_if($results->count() === 0, 404);

            return $results->pluck(['id'])->toArray();
        }

        return null;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('live', true);
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
}
