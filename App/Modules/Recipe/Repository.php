<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Traits\Filterable;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<Recipe> */
class Repository extends AbstractRepository
{
    use Filterable;
    use Searchable;

    protected array $withs = ['images', 'images.image'];

    /** @return class-string<BaseModel<Recipe>> */
    protected function model(): string
    {
        return Recipe::class; //@phpstan-ignore-line
    }

    protected function order(Builder $builder): void
    {
        $builder->latest();
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->where('live', true);
    }
}
