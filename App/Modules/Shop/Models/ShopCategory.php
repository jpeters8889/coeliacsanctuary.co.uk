<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\DisplaysImages;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\Linkable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @extends BaseModel<ShopCategory>
 *
 * @property string $title
 * @property string $meta_description
 * @property string $meta_keywords
 */
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

    public static function withLiveProducts(?Builder $query = null): Builder
    {
        if (! $query) {
            $query = self::query();
        }

        return $query->whereHas('products', static function ($productQuery) {
            /* @var $productQuery Builder */
            return $productQuery->whereHas('variants', static function ($variantQuery) {
                /* @var $variantQuery Builder */
                $variantQuery->where('live', 1);
            });
        });
    }

    protected function linkRoot(): string
    {
        return 'shop';
    }
}
