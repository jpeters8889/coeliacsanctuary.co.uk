<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Traits;

use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CacheableModelTest extends TestCase
{
    /** @test */
    public function itEmptiesTheCacheWhenAModelIsSaved()
    {
        $cacheRepository = Container::getInstance()->make(CacheRepository::class);
        $configRepository = Container::getInstance()->make(ConfigRepository::class);

        $key = Arr::first($configRepository->get('coeliac.cache.blogs'));

        $cacheRepository->put($key, 'foobar');

        $this->assertNotNull($cacheRepository->get($key));

        $blog = $this->create(Blog::class);

        $this->assertNull($cacheRepository->get($key));

        $cacheRepository->put($key, 'foobar');

        $this->assertNotNull($cacheRepository->get($key));

        $blog->update(['title' => 'foo']);

        $this->assertNull($cacheRepository->get($key));
    }
}
