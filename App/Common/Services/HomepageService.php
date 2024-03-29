<?php

declare(strict_types=1);

namespace Coeliac\Common\Services;

use Carbon\Carbon;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Coeliac\Modules\EatingOut\WhereToEat\Repository as WteRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Support\LatestPlaces;
use Coeliac\Modules\EatingOut\WhereToEat\Support\LatestRatings;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Coeliac\Modules\Shop\ProductRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Collection;

class HomepageService
{
    private CacheRepository $cacheRepository;

    private ConfigRepository $configRepository;

    public function __construct(CacheRepository $cacheRepository, ConfigRepository $configRepository)
    {
        $this->cacheRepository = $cacheRepository;
        $this->configRepository = $configRepository;
    }

    public function blogs(): Collection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.blogs.homepage_count'),
            fn () => Container::getInstance()->make(BlogRepository::class)->take(2)
        );
    }

    public function recipes(): Collection
    {
        return $this->cacheRepository->rememberForever(
            $this->configRepository->get('coeliac.cache.recipes.homepage_count'),
            fn () => Container::getInstance()->make(RecipeRepository::class)->take(3)
        );
    }

    public function ratings(): Collection
    {
        return $this->cacheRepository->remember(
            'homepage_latest_wte_ratings',
            Carbon::now()->addHour(),
            fn () => Container::getInstance()->make(LatestRatings::class)->list(),
        );
    }

    public function latestPlaces(): Collection
    {
        return $this->cacheRepository->remember(
            'homepage_latest_wte_latest_places',
            Carbon::now()->addHour(),
            fn () => Container::getInstance()->make(LatestPlaces::class)->list(),
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
                'wte_count' => Container::getInstance()->make(WteRepository::class)->count(),
                'wte_reviews_count' => WhereToEatReview::query()->where('approved', 1)->count(),
            ])
        );
    }
}
