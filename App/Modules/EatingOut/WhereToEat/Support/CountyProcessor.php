<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Support;

use Carbon\Carbon;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\JoinClause;

class CountyProcessor
{
    protected WhereToEatCounty $county;
    protected DatabaseManager $database;
    protected Repository $cache;

    public function __construct(WhereToEatCounty $county, DatabaseManager $database, Repository $cache)
    {
        $this->county = $county;
        $this->database = $database;
        $this->cache = $cache;
    }

    public function county(): WhereToEatCounty
    {
        return $this->county;
    }

    public function topRatedPlaces(): Collection
    {
        if ($this->cache->has("wheretoeat_county_{$this->county->slug}_top_places")) {
            return $this->cache->get("wheretoeat_county_{$this->county->slug}_top_places");
        }

        $places = $this->county->eateries()
            ->where('live', true)
            ->whereHas('userReviews')
            ->leftJoin('wheretoeat_reviews', function (JoinClause $join) {
                $join->on('wheretoeat_reviews.wheretoeat_id', 'wheretoeat.id')
                    ->where('approved', true);
            })
            ->select('wheretoeat.*')
            ->addSelect($this->database->raw('avg(rating) as rating'))
            ->addSelect($this->database->raw('count(wheretoeat_reviews.wheretoeat_id) as rating_count'))
            ->with(['county', 'town'])
            ->groupBy('wheretoeat.id')
            ->orderByRaw('rating desc, rating_count desc')
            ->take(3)
            ->get();

        $this->cache->put("wheretoeat_county_{$this->county->slug}_top_places", $places, Carbon::now()->addDay());

        return $places;
    }

    public function keywords(): array
    {
        return [
            "coeliac {$this->county->county}", "gluten free {$this->county->county}", "gluten free food {$this->county->county}",
            "gluten free places to eat in {$this->county->county}", 'gluten free places to eat', 'gluten free cafes',
            'gluten free restaurants', 'gluten free uk', 'places to eat', 'cafes', 'restaurants', 'eating out',
            'catering to coeliac', 'eating out uk', 'gluten free venues', 'gluten free dining',
            'gluten free directory', 'gf food', $this->county->county,
        ];
    }
}
