<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\Linkable;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\DisplaysImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ShopCategory extends BaseModel
{
    use ArchitectModel;
    use Imageable;
    use DisplaysImages;
    use Linkable;

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(ShopProduct::class, 'shop_product_categories', 'category_id', 'product_id');
    }

    public function scopeLiveProducts(Builder $query)
    {
        return $query->whereHas('products', static function ($productQuery) {
            /* @var $productQuery Builder */
            return $productQuery->whereHas('variants', static function ($variantQuery) {
                /* @var $variantQuery Builder */
                $variantQuery->where('live', 1);
            });
        });
    }

    public function scopeWithLiveProducts(Builder $query)
    {
        return $this->scopeLiveProducts($query);
    }

    protected function linkRoot()
    {
        return 'shop';
    }
}
