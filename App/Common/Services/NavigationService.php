<?php

namespace Coeliac\Common\Services;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class NavigationService
{
    private CacheRepository $cacheRepository;

    private ConfigRepository $configRepository;

    public function __construct(CacheRepository $cacheRepository, ConfigRepository $configRepository)
    {
        $this->cacheRepository = $cacheRepository;
        $this->configRepository = $configRepository;
    }

    public function blogs(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.blogs.navigation'),
            fn () => Container::getInstance()->make(BlogRepository::class)
                ->setColumns(['id', 'title', 'slug', 'meta_description'])
                ->setWiths(['images'])
                ->take(8)
        );
    }

    public function products(): EloquentCollection
    {
        return $this->cacheRepository->remember(
            $this->configRepository->get('coeliac.cache.shop.navigation'),
            Carbon::now()->addDay(),
            fn () => ShopProduct::query()
                ->withLiveProducts()
                ->orderByRaw('(select sum(shop_order_items.quantity)
                from shop_order_items
                left join shop_orders on shop_order_items.order_id = shop_orders.id
                where shop_order_items.product_id = shop_products.id and shop_orders.state_id in(2,3,4,5)) desc')
                ->with(['images'])
                ->take(8)
                ->get()
                ->transform(static function (ShopProduct $product) {
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'slug' => $product->slug,
                        'meta_description' => $product->meta_description,
                        'main_image' => $product->first_image,
                        'link' => $product->link,
                    ];
                })
        );
    }

    public function recipes(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.recipes.navigation'),
            fn () => Container::getInstance()->make(RecipeRepository::class)
                ->setColumns(['id', 'title', 'slug', 'meta_description'])
                ->take(8)
        );
    }
}
