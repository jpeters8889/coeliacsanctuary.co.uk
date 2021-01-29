<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Laravel\Scout\Builder;
use Coeliac\Modules\Shop\Models\ShopProduct;

class Product extends Index
{
    protected function model(): Builder
    {
        return ShopProduct::search($this->term);
    }
}
