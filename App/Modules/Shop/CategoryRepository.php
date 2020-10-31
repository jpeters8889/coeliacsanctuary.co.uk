<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop;

use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Common\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    protected $withs = ['images', 'images.image', 'products', 'products.variants', 'products.prices'];

    protected function model(): string
    {
        return ShopCategory::class;
    }

    protected function order(Builder &$builder)
    {
        $builder->orderBy('title');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->withLiveProducts();
    }
}
