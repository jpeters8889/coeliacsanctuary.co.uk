<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Support;

use Carbon\Carbon;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Collection;

use function numberToWords;

class IndexCountyList
{
    private CacheRepository $cacheRepository;

    public function __construct(CacheRepository $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }

    public function topPlaces(): Collection
    {
        if ($this->cacheRepository->has('wheretoeat_index_county_top_places')) {
            return $this->cacheRepository->get('wheretoeat_index_county_top_places');
        }

        $topPlaces = WhereToEat::query()
            ->addSelect([
                'average_rating' => WhereToEatReview::query()
                    ->whereColumn('wheretoeat_reviews.wheretoeat_id', 'wheretoeat.id')
                    ->where('approved', true)
                    ->selectRaw('ifnull(round(avg(rating) * 2) / 2, 0)'),
            ])
            ->addSelect([
                'number_of_ratings' => WhereToEatReview::query()
                    ->whereColumn('wheretoeat_reviews.wheretoeat_id', 'wheretoeat.id')
                    ->where('approved', true)
                    ->selectRaw('count(*)'),
            ])
            ->with(['town', 'county', 'userReviews'])
            ->orderByDesc('average_rating')
            ->orderByDesc('number_of_ratings')
            ->take(3)
            ->get();

        $this->cacheRepository->put('wheretoeat_index_county_top_places', $topPlaces, Carbon::tomorrow());

        return $topPlaces;
    }

    public function getStats(): array
    {
        $places = [];

        $this->resolveList()
            ->reject(fn ($place) => $place->country === 'Nationwide')
            ->each(function ($place) use (&$places) {
                $places[$place->country]['list'][] = [
                    'name' => $place->county,
                    'slug' => $place->county_slug,
                    'details' => [
                        'total' => $place->wte + $place->attractions + $place->hotels,
                        'eateries' => $place->wte,
                        'attractions' => $place->att,
                        'hotels' => $place->hotel,
                    ],
                ];
            });

        foreach ($places as &$place) {
            $place['counties'] = numberToWords(count($place['list']));
            $place['count'] = numberToWords(array_sum(collect($place['list'])->pluck('details')->pluck('total')->toArray()));
        }

        return $places;
    }

    private function resolveList(): Collection
    {
        if ($this->cacheRepository->has('wheretoeat_index_county_status')) {
            return $this->cacheRepository->get('wheretoeat_index_county_status');
        }

        $list = WhereToEat::query()
            ->selectRaw('wheretoeat_countries.country, wheretoeat_counties.county, wheretoeat_counties.slug county_slug')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 1 THEN 1 ELSE 0 END) wte')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 2 THEN 1 ELSE 0 END) att')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 2 THEN 1 ELSE 0 END) hotel')
            ->where('wheretoeat.live', true)
            ->leftJoin('wheretoeat_countries', 'country_id', 'wheretoeat_countries.id')
            ->leftJoin('wheretoeat_counties', 'county_id', 'wheretoeat_counties.id')
            ->leftJoin('wheretoeat_types', 'type_id', 'wheretoeat_types.id')
            ->groupBy('wheretoeat_countries.country', 'wheretoeat_counties.county', 'wheretoeat_counties.slug')
            ->orderBy('country')
            ->orderBy('county')
            ->get();

        $this->cacheRepository->put('wheretoeat_index_county_status', $list);

        return $list;
    }
}
