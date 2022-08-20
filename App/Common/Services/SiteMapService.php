<?php

declare(strict_types=1);

namespace Coeliac\Common\Services;

use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Coeliac\Modules\Shop\CategoryRepository;
use Coeliac\Modules\Shop\ProductRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class SiteMapService
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
            $this->configRepository->get('coeliac.cache.blogs.sitemap'),
            fn () => Container::getInstance()->make(BlogRepository::class)->all()
        );
    }

    public function counties(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.wheretoeat.counties'),
            fn () => WhereToEatCounty::query()
                ->where('county', '!=', 'Nationwide')
                ->get()
        );
    }

    public function recipes(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.recipes.sitemap'),
            fn () => Container::getInstance()->make(RecipeRepository::class)->all()
        );
    }

    public function reviews(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.reviews.sitemap'),
            fn () => Container::getInstance()->make(ReviewRepository::class)->all()
        );
    }

    public function shopCategories(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.shop.categories'),
            fn () => Container::getInstance()->make(CategoryRepository::class)->all()
        );
    }

    public function shopProducts(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.shop.products'),
            fn () => Container::getInstance()->make(ProductRepository::class)->all()
        );
    }

    public function towns(): EloquentCollection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.wheretoeat.towns'),
            fn () => WhereToEatTown::query()
                ->where('town', '!=', 'Nationwide')
                ->with('county')
                ->orderBy('town')
                ->get()
        );
    }
}
