<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews;

use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected $withs = ['images', 'images.image'];

    protected function model(): string
    {
        return Review::class;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('live', true)->latest();
    }
}
