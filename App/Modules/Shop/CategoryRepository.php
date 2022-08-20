<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Illuminate\Database\Eloquent\Builder;

/** @extends AbstractRepository<ShopCategory> */
class CategoryRepository extends AbstractRepository
{
    protected array $withs = ['images', 'images.image', 'products', 'products.variants', 'products.prices'];

    /** @return class-string<BaseModel<ShopCategory>> */
    protected function model(): string
    {
        return ShopCategory::class; //@phpstan-ignore-line
    }

    protected function order(Builder $builder): void
    {
        $builder->orderBy('title');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return ShopCategory::withLiveProducts($query);
    }
}
