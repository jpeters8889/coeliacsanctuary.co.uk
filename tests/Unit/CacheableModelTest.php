<?php

namespace Tests\Unit;

use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;
use Tests\Traits\CreatesBlogs;

class CacheableModelTest extends TestCase
{
    use RefreshDatabase;
    use CreatesBlogs;

    /** @test */
    public function it_empties_the_cache_when_a_model_is_saved()
    {
        $cacheRepository = Container::getInstance()->make(CacheRepository::class);
        $configRepository = Container::getInstance()->make(ConfigRepository::class);

        $key = Arr::first($configRepository->get('coeliac.cache.blogs'));

        $cacheRepository->put($key, 'foobar');

        $this->assertNotNull($cacheRepository->get($key));

        $blog = $this->createBlog();

        $this->assertNull($cacheRepository->get($key));

        $cacheRepository->put($key, 'foobar');

        $this->assertNotNull($cacheRepository->get($key));

        $blog->update(['title' => 'foo']);

        $this->assertNull($cacheRepository->get($key));
    }
}
