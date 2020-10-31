<?php

declare(strict_types=1);

namespace Tests\Traits\Shop;

use Coeliac\Modules\Shop\Models\ShopCategory;

trait CreateCategory
{
    protected function createCategory($params = [])
    {
        return factory(ShopCategory::class)->create($params);
    }
}
