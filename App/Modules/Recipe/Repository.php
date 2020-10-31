<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe;

use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected $withs = ['images', 'images.image'];

    protected function model(): string
    {
        return Recipe::class;
    }

    protected function order(Builder &$builder)
    {
        $builder->latest();
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('live', true);
    }
}
