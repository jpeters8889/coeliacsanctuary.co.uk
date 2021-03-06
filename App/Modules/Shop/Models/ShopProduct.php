<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Support\Collection;
use Coeliac\Common\Traits\Linkable;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\DisplaysImages;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Search\SearchableContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Coeliac\Modules\Collection\Traits\IsCollectionItem;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int                            $currentPrice
 * @property mixed|string                   $oldPrice
 * @property mixed|string                   $id
 * @property mixed|string                   $title
 * @property mixed|string                   $slug
 * @property mixed|string                   $short_description
 * @property mixed|string                   $long_description
 * @property ShopShippingMethod             $shippingMethod
 * @property mixed|string                   $mainImage
 * @property mixed|string                   $meta_tags
 * @property Collection<ShopProductVariant> $variants
 * @property Collection<ShopProductPrice>   $prices
 *
 * @method transform(array $array)
 */
class ShopProduct extends BaseModel implements SearchableContract
{
    use DisplaysImages;
    use Imageable;
    use IsCollectionItem;
    use Searchable;
    use Linkable;
    use ArchitectModel;

    protected $appends = [
        'price',
        'first_image',
    ];

    protected $visible = [
        'id',
        'title',
        'link',
        'price',
        'first_image',
    ];

    protected function linkRoot()
    {
        return 'shop/product';
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->title,
            'description' => $this->description,
            'metaTags' => $this->meta_keywords,
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return $this->variants->filter(static function ($query) {
            return (bool) $query->live;
        })->count() > 0;
    }

    public function feedback()
    {
        return $this->hasMany(ShopFeedback::class, 'product_id');
    }

    public function getScoutKey()
    {
        return $this->id;
    }

    public function getPriceAttribute(): array
    {
        if ($this->oldPrice !== null && $this->oldPrice !== 0) {
            return [
                'current_price' => $this->currentPrice,
                'old_price' => $this->oldPrice,
            ];
        }

        return [
            'current_price' => $this->currentPrice,
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ShopCategory::class, 'shop_product_categories', 'product_id', 'category_id');
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShopShippingMethod::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ShopProductVariant::class, 'product_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ShopProductPrice::class, 'product_id');
    }

    public function currentPrices()
    {
        return $this->prices
            ->filter(fn (ShopProductPrice $price) => $price->start_at->lessThan(Carbon::now()))
            ->filter(fn (ShopProductPrice $price) => !$price->end_at || $price->end_at->endOfDay()->greaterThan(Carbon::now()))
            ->sortByDesc('start_at');
    }

    public function getCurrentPriceAttribute()
    {
        return $this->currentPrices()
            ->first()
            ->price;
    }

    public function getOldPriceAttribute()
    {
        if ((bool) $this->currentPrices()->first()->sale_price === true) {
            return $this->currentPrices()->skip(1)->first()->price;
        }

        return null;
    }

    public function scopeWithLiveProducts(Builder $builder)
    {
        return $builder->whereHas('variants', static function (Builder $query) {
            return $query->where('live', true);
        });
    }

    protected static function bodyField()
    {
        return 'long_description';
    }
}
