<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Shop\ProductRepository;

class ProductShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return (new ProductRepository())->setWiths(['variants', 'images', 'images.image']);
    }
}
