<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

/** @mixin TestCase */
trait InteractsWithRedis
{
    protected function tearDown(): void
    {
        Redis::flushall();

        parent::tearDown();
    }

    public static function setupRedis()
    {
        if (ParallelTesting::token()) {
            Config::set('database.redis.default.database', ParallelTesting::token());
        }

        Redis::flushall();
    }
}
