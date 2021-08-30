<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat;

use RuntimeException;
use Illuminate\Http\Request;
use Spatie\Geocoder\Geocoder;
use Illuminate\Container\Container;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected array $appends = [];

    public function getAppends(): array
    {
        return $this->appends;
    }

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
                ->getCoordinatesForAddress($parameters['term']);

            return [
                'lat' => $geocoder['lat'],
                'lng' => $geocoder['lng'],
            ];
        }

        throw new RuntimeException('No search parameters');
    }

    protected function performSearch(string $model): array|null
    {
        if (!$this->useSearch) {
            return null;
        }

        /** @var Request $request */
        $request = Container::getInstance()->make(Request::class);

        if ($request->has('search')) {
            $parameters = json_decode($request->get('search'), true);

            /** @var WhereToEat $model */

            /** @phpstan-ignore-next-line */
            $results = $model::search()
                ->with([
                    'aroundLatLng' => implode(', ', $latlng = $this->resolveLatLng((array) array_filter($parameters))),
                    'aroundRadius' => (int) round(((int) $parameters['range']) * 1609.344),
                    'getRankingInfo' => true,
                ])
                ->get();

            $results = $results->reject(fn (WhereToEat $whereToEat) => $whereToEat->county_id === 1)
                ->each(function ($result) {
                    $this->appends[$result->id] = [
                        'distance' => round($result->scoutMetadata()['_rankingInfo']['geoDistance'] / 1609, 1),
                    ];
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
        $builder->orderBy('name');
    }
}
