<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Traits\Searchable;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/** @extends AbstractRepository<ShopProduct> */
class ProductRepository extends AbstractRepository
{
    use Searchable;

    protected array $withs = ['images', 'images.image', 'prices'];

    /** @return class-string<BaseModel<ShopProduct>> */
    protected function model(): string
    {
        return ShopProduct::class; //@phpstan-ignore-line
    }

    protected function order(Builder $builder): void
    {
        $builder->orderBy('title');
    }

    protected function modifyQuery(Builder $query): Builder
    {
        return ShopProduct::withLiveProducts($query);
    }

    public function fromCategory(string $category): Collection
    {
        return $this->query()
            ->whereHas('categories', static fn (Builder $query) => $query->where('slug', $category))
            ->get();
    }
}
