<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Filters;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;

class WhereToEatFilter extends AbstractFilter
{
    protected $availableFilters = [
        'county',
        'town',
        'type',
        'venueType',
        'cuisine',
        'has',
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
        return $builder->where('type_id', $value);
    }

    protected function filterVenueType(Builder $builder, $value)
    {
        return $builder->whereIn('venue_type_id', explode(',', $value));
    }

    protected function filterCuisine(Builder $builder, $value)
    {
        return $builder->where('cuisine_id', $value);
    }

    protected function filterHas(Builder $builder, $value)
    {
        if ($value !== 'reviews') {
            return $builder;
        }

        return $builder->whereHas('reviews');
    }
}
