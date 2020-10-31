<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Requests;

use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Modules\Shop\CategoryRepository;
use Coeliac\Common\Repositories\AbstractRepository;

class CategoryShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new CategoryRepository();
    }

    public function products()
    {
        return (new ProductRepository())
            ->setWiths(['images', 'images.image', 'variants', 'prices'])
            ->fromCategory($this->route('slug'));
    }
}
