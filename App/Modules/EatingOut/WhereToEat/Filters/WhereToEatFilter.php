<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Filters;

use Coeliac\Common\Filters\AbstractFilter;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Illuminate\Database\Eloquent\Builder;

class WhereToEatFilter extends AbstractFilter
{
    protected array $availableFilters = [
        'county',
        'town',
        'type',
        'venueType',
        'cuisine',
        'has',
        'feature',
    ];

    protected array $rawFilters = [
        'rating',
    ];

    protected function filterCounty(Builder $builder, mixed $value): Builder
    {
        return $builder->where('wheretoeat.county_id', $value);
    }

    protected function filterTown(Builder $builder, mixed $value): Builder
    {
        return $builder->where('wheretoeat.town_id', $value);
    }

    protected function filterType(Builder $builder, mixed $value): Builder
    {
        return $builder->whereIn('type_id', explode(',', $value));
    }

    protected function filterVenueType(Builder $builder, mixed $value): Builder
    {
        return $builder->whereIn('venue_type_id', explode(',', $value));
    }

    protected function filterCuisine(Builder $builder, mixed $value): Builder
    {
        return $builder->where('cuisine_id', $value);
    }

    protected function filterFeature(Builder $builder, mixed $value): Builder
    {
        foreach (explode(',', $value) as $feature) {
            $builder->orWhereHas('features', fn (Builder $query) => $query->where('id', $feature));
        }

        return $builder;
    }

    protected function filterRating(Builder $builder, mixed $value): Builder
    {
        $value = explode(',', $value);
        $having = 'average_rating in (' . trim(str_repeat('?,', count($value)), ',') . ')';

        return $builder
            ->addSelect([
                'average_rating' => WhereToEatReview::query()
                    ->whereColumn('wheretoeat_reviews.wheretoeat_id', 'wheretoeat.id')
                    ->where('approved', true)
                    ->selectRaw('ifnull(round(avg(rating) * 2) / 2, 0)'),
            ])
            ->havingRaw($having, $value);
    }

    protected function filterHas(Builder $builder, mixed $value): Builder
    {
        if ($value !== 'reviews') {
            return $builder;
        }

        return $builder->whereHas('reviews');
    }
}
