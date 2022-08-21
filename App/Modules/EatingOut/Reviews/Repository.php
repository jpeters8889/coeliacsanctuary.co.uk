<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<Review> */
class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected array $withs = ['images', 'images.image'];

    /** @return class-string<BaseModel<Review>> */
    protected function model(): string
    {
        return Review::class;
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('live', true)->latest();
    }
}
