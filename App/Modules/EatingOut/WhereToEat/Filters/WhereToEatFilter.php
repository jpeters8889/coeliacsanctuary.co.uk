<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Filters;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class WhereToEatFilter extends AbstractFilter
{
    protected $availableFilters = [
        'county',
        'town',
        'type',
        'venueType',
        'cuisine',
        'has',
        'feature',
    ];

    protected $rawFilters = [
        'rating'
    ];

    protected function filterCounty(Builder $builder, $value)
    {
        return $builder->where('county_id', $value);
    }

    protected function filterTown(Builder $builder, $value)
    {
        return $builder->where('town_id', $value);
    }

    protected function filterType(Builder $builder, $value)
    {
        return $builder->whereIn('type_id', explode(',', $value));
    }

    protected function filterVenueType(Builder $builder, $value)
    {
        return $builder->whereIn('venue_type_id', explode(',', $value));
    }

    protected function filterCuisine(Builder $builder, $value)
    {
        return $builder->where('cuisine_id', $value);
    }

    protected function filterFeature(Builder $builder, $value)
    {
        foreach (explode(',', $value) as $feature) {
            $builder->orWhereHas('features', fn (Builder $query) => $query->where('id', $feature));
        }

        return $builder;
    }

    protected function filterRating(Builder $builder, $value)
    {
        $value = explode(',', $value);
        $having = 'average_rating in (' . trim(str_repeat('?,', count($value)), ',') . ')';

        return $builder
            ->addSelect([
                'average_rating' => WhereToEatRating::query()
                    ->whereColumn('wheretoeat_ratings.wheretoeat_id', 'wheretoeat.id')
                    ->where('approved', true)
                    ->selectRaw('ifnull(round(avg(rating) * 2) / 2, 0)')
            ])
            ->havingRaw($having, $value);
    }

    protected function filterHas(Builder $builder, $value)
    {
        if ($value !== 'reviews') {
            return $builder;
        }

        return $builder->whereHas('reviews');
    }
}
