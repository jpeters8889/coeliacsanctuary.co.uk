<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Algolia\ScoutExtended\Builder;
use Coeliac\Modules\Shop\Models\ShopProduct;

class Product extends Index
{
    protected function model(): Builder|\Laravel\Scout\Builder
    {
        return ShopProduct::search($this->term);
    }
}
