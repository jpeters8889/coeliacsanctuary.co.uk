<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat;

use Illuminate\Database\Eloquent\Collection;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class IndexCountyList
{
    private \Illuminate\Cache\Repository $cacheRepository;

    public function __construct(\Illuminate\Cache\Repository $cacheRepository)
    {
        $this->cacheRepository = $cacheRepository;
    }

    public function getStats(): array
    {
        $places = [];

        $this->resolveList()
            ->each(function ($place) use (&$places) {
                $places[$place->country][$place->county] = $this->countyComment($place);
            });

        return $places;
    }

    private function countyComment($place)
    {
        return implode(
            ', ',
            array_filter([
                $this->pluralise($place->wte, 'Eatery', 'Eateries'),
                $this->pluralise($place->att, 'Attraction'),
                $this->pluralise($place->hotel, 'Hotel'),
            ])
        );
    }

    private function pluralise($count, $name, $plural = null)
    {
        if (!$plural) {
            $plural = $name.'s';
        }

        if ($count > 0) {
            if ($count === 1) {
                return '1 '.$name;
            }

            return $count.' '.$plural;
        }

        return false;
    }

    private function resolveList(): Collection
    {
        if ($this->cacheRepository->has('wheretoeat_index_county_status')) {
            return $this->cacheRepository->get('wheretoeat_index_county_status');
        }

        $list = WhereToEat::query()
            ->selectRaw('wheretoeat_countries.country, wheretoeat_counties.county')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 1 THEN 1 ELSE 0 END) wte')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 2 THEN 1 ELSE 0 END) att')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 2 THEN 1 ELSE 0 END) hotel')
            ->where('wheretoeat.live', true)
            ->leftJoin('wheretoeat_countries', 'country_id', 'wheretoeat_countries.id')
            ->leftJoin('wheretoeat_counties', 'county_id', 'wheretoeat_counties.id')
            ->leftJoin('wheretoeat_types', 'type_id', 'wheretoeat_types.id')
            ->groupBy('wheretoeat_countries.country', 'wheretoeat_counties.county')
            ->orderBy('country')
            ->orderBy('county')
            ->get();

        $this->cacheRepository->put('wheretoeat_index_county_status', $list);

        return $list;
    }
}
