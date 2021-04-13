<?php

declare(strict_types=1);

namespace Tests\Traits;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\ParallelTesting;

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
