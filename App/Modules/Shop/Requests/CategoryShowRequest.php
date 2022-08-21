<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Shop\CategoryRepository;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\ProductRepository;
use Illuminate\Database\Eloquent\Collection;

/** @extends ModuleRequest<ShopCategory> */
class CategoryShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new CategoryRepository();
    }

    public function products(): Collection
    {
        return (new ProductRepository())
            ->setWiths(['images', 'images.image', 'variants', 'prices', 'reviews'])
            ->fromCategory((string) $this->route('slug'));
    }
}
