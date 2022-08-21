<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\Collection\Models\Collection;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<Collection> */
class Repository extends AbstractRepository
{
    protected array $withs = ['images', 'images.image', 'items', 'items.item'];

    /** @return class-string<BaseModel<Collection>> */
    protected function model(): string
    {
        return Collection::class;
    }

    protected function order(Builder $builder): void
    {
        $builder->orderByDesc('updated_at');
    }
}
