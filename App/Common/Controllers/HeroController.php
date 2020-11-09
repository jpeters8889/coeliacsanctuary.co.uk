<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\FeaturedImages\Repository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class HeroController extends BaseController
{
    public function get(Repository $repository, CacheRepository $cache, ConfigRepository $config)
    {
        return $cache->rememberForever(
            $config->get('coeliac.cache.featured_images.featured_images'),
            fn () => $repository->all()
        );
    }
}
