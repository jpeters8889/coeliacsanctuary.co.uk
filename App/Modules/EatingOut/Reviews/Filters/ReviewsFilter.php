<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Filters;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;

class ReviewsFilter extends AbstractFilter
{
    protected $availableFilters = [
        'counties',
        'ratings',
    ];

    protected function filterCounties(Builder $builder, $value)
    {
        foreach (explode(',', $value) as $county) {
            $builder->whereHas('county', static function (Builder $query) use ($county) {
                return $query->where('county', $county);
            });
        }

        return $builder;
    }

    public function filterRatings(Builder $builder, $value)
    {
        return $builder->whereIn('overall_rating', explode(',', $value));
    }
}
