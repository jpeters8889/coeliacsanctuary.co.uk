<?php

declare(strict_types=1);

namespace Coeliac\Common\Filters;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    protected array $availableFilters = [];

    protected array $rawFilters = [];

    public function __construct(protected Request $request)
    {
    }

    public function filter(Builder $builder): Builder
    {
        if (!$this->request->has('filter')) {
            return $builder;
        }

        foreach ($this->request->get('filter') as $filter => $value) {
            if (empty($value)) {
                continue;
            }

            if (in_array($filter, $this->availableFilters, true)) {
                $builder->where(function (Builder $builder) use ($filter, $value) {
                    return $this->{'filter' . Str::studly($filter)}($builder, $value);
                });

                continue;
            }

            if (in_array($filter, $this->rawFilters, true)) {
                $this->{'filter' . Str::studly($filter)}($builder, $value);

                continue;
            }

            throw new Exception("Unknown {$filter} filter...");
        }

        return $builder;
    }
}
