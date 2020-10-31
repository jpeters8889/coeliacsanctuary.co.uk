<?php

declare(strict_types=1);

namespace Coeliac\Common\Filters;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class AbstractFilter
{
    private Request $request;

    protected $availableFilters = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function filter(Builder $builder)
    {
        if ($this->request->has('filter')) {
            foreach ($this->request->get('filter') as $filter => $value) {
                if (!in_array($filter, $this->availableFilters)) {
                    throw new \Exception("Unknown {$filter} filter...");
                }

                if (!empty($value)) {
                    $builder->where(function (Builder $builder) use ($filter, $value) {
                        return call_user_func([$this, 'filter'.Str::studly($filter)], $builder, $value);
                    });
                }
            }
        }

        return $builder;
    }
}
