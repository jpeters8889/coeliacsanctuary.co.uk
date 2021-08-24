<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Common\Repositories\AbstractRepository;

class Repository extends AbstractRepository
{
    protected $withs = ['images', 'images.image', 'items', 'items.item', 'items.item.images', 'items.item.images.image'];

    protected function model(): string
    {
        return Collection::class;
    }

    protected function order(Builder &$builder)
    {
        $builder->orderByDesc('updated_at');
    }
}
