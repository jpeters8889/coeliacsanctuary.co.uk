<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

/**
 * @mixin Model
 */
trait ClearsCache
{
    public static function bootClearsCache()
    {
        static::saved(function (self $model) {
            $cacheRepository = Container::getInstance()->make(CacheRepository::class);
            $configRepository = Container::getInstance()->make(ConfigRepository::class);

            $keys = $configRepository->get("coeliac.cache.{$model->cacheKey()}");

            foreach ($keys as $key) {
                $cacheRepository->delete($key);
            }
        });
    }

    abstract protected function cacheKey(): string;
}
