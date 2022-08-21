<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * @mixin TestCase
 */
trait ClearsCache
{
    /** @test */
    public function it_clears_all_cache_entries_when_the_model_is_updated()
    {
        $cacheRepository = Container::getInstance()->make(CacheRepository::class);
        $configRepository = Container::getInstance()->make(ConfigRepository::class);

        $keys = (new Collection($configRepository->get("coeliac.cache.{$this->cacheKey()}")))
            ->each(function ($key) use ($cacheRepository) {
                $cacheRepository->put($key, 'foo');
            })
            ->each(function ($key) use ($cacheRepository) {
                $this->assertNotNull($cacheRepository->get($key));
            });

        $this->makeCachedModel();

        $keys->each(function ($key) use ($cacheRepository) {
            $this->assertNull($cacheRepository->get($key));
        });
    }

    abstract protected function cacheKey(): string;

    abstract protected function makeCachedModel(): void;
}
