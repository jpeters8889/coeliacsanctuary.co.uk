<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Filters;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;

class ReviewsFilter extends AbstractFilter
{
    protected array $availableFilters = [
        'counties',
        'ratings',
    ];

    protected function filterCounties(Builder $builder, mixed $value): Builder
    {
        foreach (explode(',', $value) as $county) {
            $builder->whereHas('county', static function (Builder $query) use ($county) {
                return $query->where('county', $county);
            });
        }

        return $builder;
    }

    public function filterRatings(Builder $builder, mixed $value): Builder
    {
        return $builder->whereIn('overall_rating', explode(',', $value));
    }
}
