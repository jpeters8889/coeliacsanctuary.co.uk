<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Modules\Shop\CategoryRepository;
use Coeliac\Common\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new CategoryRepository();
    }

    public function resolveItem(array $withs = []): ?ShopCategory
    {
        /** @phpstan-ignore-next-line  */
        return parent::resolveItem($withs);
    }

    public function products(): Collection
    {
        return (new ProductRepository())
            ->setWiths(['images', 'images.image', 'variants', 'prices'])
            ->fromCategory((string) $this->route('slug'));
    }
}
