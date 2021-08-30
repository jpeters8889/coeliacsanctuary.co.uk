<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Common\Repositories\AbstractRepository;

class ProductShowRequest extends ModuleRequest
{
    public function resolveItem(array $withs = []): ?ShopProduct
    {
        /** @phpstan-ignore-next-line  */
        return parent::resolveItem($withs);
    }

    protected function repository(): AbstractRepository
    {
        return (new ProductRepository())->setWiths(['variants', 'images', 'images.image']);
    }
}
