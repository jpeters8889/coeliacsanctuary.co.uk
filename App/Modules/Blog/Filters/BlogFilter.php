<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;

class BlogFilter extends AbstractFilter
{
    protected $availableFilters = [
        'tags',
        'year',
    ];

    protected function filterTags(Builder $builder, $value)
    {
        foreach (explode(',', $value) as $tag) {
            $builder->whereHas('tags', static function (Builder $query) use ($tag) {
                return $query->where('slug', $tag);
            });
        }

        return $builder;
    }

    protected function filterYear(Builder $builder, $value)
    {
        $start = Carbon::createFromFormat('Y', $value)->startOfYear();
        $end = Carbon::createFromFormat('Y', $value)->endOfYear();

        return $builder->whereBetween('created_at', [$start, $end]);
    }
}
