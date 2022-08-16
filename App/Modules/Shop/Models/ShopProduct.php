<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Coeliac\Common\Traits\HasRichText;
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
 * @property int $currentPrice
 * @property mixed|string $oldPrice
 * @property mixed|string $id
 * @property mixed|string $title
 * @property mixed|string $slug
 * @property mixed|string $short_description
 * @property mixed|string $long_description
 * @property ShopShippingMethod $shippingMethod
 * @property mixed|string $mainImage
 * @property mixed|string $meta_tags
 * @property Collection<ShopProductVariant> $variants
 * @property Collection<ShopProductPrice> $prices
 * @property string $description
 * @property string $meta_keywords
 * @property string $meta_description
 * @property Collection<ShopCategory> $categories
 * @property Collection<ShopOrderReviewItem> $reviews
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
    use HasRichText;

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

    protected function linkRoot(): string
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
            return (bool)$query->live;
        })->count() > 0;
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(ShopFeedback::class, 'product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ShopOrderReviewItem::class, 'product_id');
    }

    public function getScoutKey(): mixed
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

    public function currentPrices(): Collection
    {
        return $this->prices
            ->filter(fn (ShopProductPrice $price) => $price->start_at->lessThan(Carbon::now()))
            ->filter(fn (ShopProductPrice $price) => !$price->end_at || $price->end_at->endOfDay()->greaterThan(Carbon::now()))
            ->sortByDesc('start_at');
    }

    public function getCurrentPriceAttribute(): mixed
    {
        return $this->currentPrices()
            ->first()
            ?->price;
    }

    public function getOldPriceAttribute(): mixed
    {
        if ((bool)$this->currentPrices()->first()?->sale_price === true) {
            return $this->currentPrices()->skip(1)->first()->price;
        }

        return null;
    }

    public static function withLiveProducts(?Builder $builder = null): Builder
    {
        if (!$builder) {
            $builder = static::query();
        }

        return $builder->whereHas('variants', static function (Builder $query) {
            return $query->where('live', true);
        });
    }

    public function travelCardSearchTerms(): BelongsToMany
    {
        return $this->belongsToMany(
            TravelCardSearchTerm::class,
            'shop_product_assigned_travel_card_search_terms',
            'product_id',
            'search_term_id',
        );
    }

    protected static function bodyField(): string
    {
        return 'long_description';
    }

    protected function richTextType(): string
    {
        return 'Product';
    }

    protected function toRichText(): array
    {
        $core = [
            'sku' => $this->id,
            'name' => $this->title,
            'brand' => [
                '@type' => 'Organization',
                'name' => 'Coeliac Sanctuary',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://www.coeliacsanctuary.co.uk/assets/svg/logo.svg',
                ],
            ],
            'description' => $this->description,
            'image' => [$this->first_image],
            'offers' => [
                "@type" => "Offer",
                'price' => $this->currentPrice / 100,
                'availability' => $this->isInStock() ? 'InStock' : 'OutOfStock',
                'priceCurrency' => 'GBP',
                'url' => $this->absolute_link,
                'shippingDetails' => [
                    '@type' => 'OfferShippingDetails',
                    'shippingDestination' => [
                        '@type' => 'DefinedRegion',
                        'addressCountry' => 'UK',
                    ],
                    'deliveryTime' => [
                        '@type' => 'ShippingDeliveryTime',
                        'businessDays' => [
                            '@type' => 'OpeningHoursSpecification',
                            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                        ],
                        'cutOffTime' => '12:00',
                        'handlingTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => 0,
                            'maxValue' => 1,
                        ],
                        'transitTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => 1,
                            'maxValue' => 3,
                        ],
                    ],
                    'shippingRate' => [
                        '@type' => 'MonetaryAmount',
                        'currency' => 'GBP',
                        'value' => $this->baseShippingRate() / 100,
                    ],
                ],
            ],
        ];

        if ($this->reviews()->count() > 0) {
            $core = array_merge($core, [
                "review" => $this->reviews()->latest()->with(['parent'])->get()->transform(fn (ShopOrderReviewItem $review) => [
                    "@type" => "Review",
                    "reviewRating" => [
                        "@type" => "Rating",
                        "ratingValue" => $review->rating,
                        "bestRating" => "5"
                    ],
                    "author" => [
                        "@type" => "Person",
                        "name" => $review->parent->name,
                    ],
                ]),
                "aggregateRating" => [
                    "@type" => "AggregateRating",
                    "ratingValue" => $this->reviews()->average('rating'),
                    "reviewCount" => $this->reviews()->count()
                ],
            ]);
        }

        return $core;
    }

    protected function baseShippingRate(): int
    {
        return $this
            ->shippingMethod
            ->prices()
            ->where('postage_country_area_id', 1)
            ->where('max_weight', '>', $this->variants[0]->weight)
            ->orderBy('price')
            ->first()
            ->price;
    }

    protected function isInStock(): bool
    {
        return $this
                ->variants
                ->pluck('quantity')
                ->filter(fn ($quantity) => $quantity > 0)
                ->count() > 0;
    }
}
