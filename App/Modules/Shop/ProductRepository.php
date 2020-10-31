<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop;

use Coeliac\Common\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Common\Repositories\AbstractRepository;

class ProductRepository extends AbstractRepository
{
    use Searchable;

    protected $withs = ['images', 'images.image', 'prices'];

    protected function model(): string
    {
        return ShopProduct::class;
    }

    protected function order(Builder &$builder)
    {
        $builder->orderBy('title');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return $query->withLiveProducts();
    }

    public function fromCategory($category)
    {
        return $this->query()->whereHas('categories', static function (Builder $query) use ($category) {
            return $query->where('slug', $category);
        })->get();
    }
}
