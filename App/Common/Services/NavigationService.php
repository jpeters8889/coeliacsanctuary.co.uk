<?php

declare(strict_types=1);

namespace Coeliac\Common\Services;

use Carbon\Carbon;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\Collection\Repository as CollectionRepository;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Container\Container;
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
        $products = ShopProduct::withLiveProducts()
            ->orderByRaw('(select sum(shop_order_items.quantity)
                from shop_order_items
                left join shop_orders on shop_order_items.order_id = shop_orders.id
                where shop_order_items.product_id = shop_products.id
                and shop_orders.state_id in(2,3,4,5)
                and shop_orders.created_at > ?) desc', [Carbon::now()->subDays(2)->startOfDay()->toDateTimeString()])
            ->with(['images'])
            ->take(7)
            ->get()
            ->transform(fn (ShopProduct $product) => [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'meta_description' => $product->meta_description,
                'main_image' => $product->first_image,
                'link' => $product->link,
            ]);

        $products->prepend([
            'id' => 0,
            'title' => 'Gluten Free Travel and Translation Cards',
            'slug' => '',
            'meta_description' => 'Travel the world and eat out safely with our fantastic range of gluten free travel and translation cards!',
            'main_image' => '/assets/images/misc/shop-travel-cards.jpg',
            'link' => $this->configRepository->get('app.url').'/gluten-free-travel-translation-cards',
        ]);

        return $this->cacheRepository->remember(
            $this->configRepository->get('coeliac.cache.shop.navigation'),
            Carbon::now()->addDay(),
            fn () => $products
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

    public function collections(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.collections.navigation'),
            fn () => Container::getInstance()->make(CollectionRepository::class)
                ->setColumns(['id', 'title', 'slug', 'meta_description'])
                ->setWiths(['images', 'images.image'])
                ->take(8)
        );
    }
}
