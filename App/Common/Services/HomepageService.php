<?php

declare(strict_types=1);

namespace Coeliac\Common\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Coeliac\Modules\Shop\ProductRepository;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Repository as WteRepository;

class HomepageService
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
            $this->configRepository->get('coeliac.cache.blogs.homepage_count'),
            fn () => Container::getInstance()->make(BlogRepository::class)->take(2)
        );
    }

    public function recipes(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.recipes.homepage_count'),
            fn () => Container::getInstance()->make(RecipeRepository::class)->take(3)
        );
    }

    public function reviews(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.reviews.homepage_count'),
            fn () => Container::getInstance()->make(ReviewRepository::class)->take(2)
        );
    }

    public function statistics(): Collection
    {
        return $this->cacheRepository->remember(
            $this->configRepository->get('coeliac.cache.homepage_stats'),
            Carbon::now()->addDay(),
            fn () => new Collection([
                'product_count' => Container::getInstance()->make(ProductRepository::class)->count(),
                'blog_count' => Container::getInstance()->make(BlogRepository::class)->count(),
                'recipe_count' => Container::getInstance()->make(RecipeRepository::class)->count(),
                'review_count' => Container::getInstance()->make(ReviewRepository::class)->count(),
                'wte_count' => Container::getInstance()->make(WteRepository::class)->count(),
            ])
        );
    }
}
