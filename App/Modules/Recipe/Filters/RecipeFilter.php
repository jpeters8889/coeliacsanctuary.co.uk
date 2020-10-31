<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Filters;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;

class RecipeFilter extends AbstractFilter
{
    protected $availableFilters = [
        'feature',
        'freefrom',
        'meal',
    ];

    protected function filterFeature(Builder $builder, $value)
    {
        foreach (explode(',', $value) as $feature) {
            $builder->whereHas('features', static function (Builder $query) use ($feature) {
                return $query->where('feature', $feature);
            });
        }

        return $builder;
    }

    protected function filterFreefrom(Builder $builder, $value)
    {
        foreach (explode(',', $value) as $allergen) {
            $builder->whereHas('allergens', static function (Builder $query) use ($allergen) {
                return $query->where('allergen', $allergen);
            });
        }

        return $builder;
    }

    protected function filterMeal(Builder $builder, $value)
    {
        foreach (explode(',', $value) as $meal) {
            $builder->whereHas('meals', static function (Builder $query) use ($meal) {
                return $query->where('meal', $meal);
            });
        }

        return $builder;
    }
}
