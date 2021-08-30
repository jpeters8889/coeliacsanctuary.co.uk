<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Filters;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Filters\AbstractFilter;

class BlogFilter extends AbstractFilter
{
    protected array $availableFilters = [
        'tags',
        'year',
    ];

    protected function filterTags(Builder $builder, mixed $value): Builder
    {
        foreach (explode(',', $value) as $tag) {
            $builder->whereHas('tags', static function (Builder $query) use ($tag) {
                return $query->where('slug', $tag);
            });
        }

        return $builder;
    }

    protected function filterYear(Builder $builder, mixed $value): Builder
    {
        /** @var Carbon $carbon */
        $carbon = Carbon::createFromFormat('Y', $value);

        return $builder->whereDate('created_at', '>=', $carbon->startOfYear())
            ->whereDate('created_at', '<=', $carbon->endOfYear());
    }
}
