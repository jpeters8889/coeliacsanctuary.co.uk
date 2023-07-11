<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Filters;

use Illuminate\Database\Eloquent\Builder;

class WhereToEatNationwideFilter extends WhereToEatFilter
{
    protected function filterCounty(Builder $builder, mixed $value): Builder
    {
        return $builder->where('wheretoeat_nationwide_branches.county_id', $value);
    }

    protected function filterTown(Builder $builder, mixed $value): Builder
    {
        return $builder->where('wheretoeat_nationwide_branches.town_id', $value);
    }
}
