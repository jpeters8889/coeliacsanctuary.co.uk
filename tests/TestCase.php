<?php

declare(strict_types=1);

namespace Tests;

use Coeliac\Common\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdminUser()
    {
        factory(User::class)->create(['email' => 'contact@coeliacsanctuary.co.uk']);
    }

    protected function assertArrayHas($key, $value, $haystack): void
    {
        $this->assertArrayHasKey($key, $haystack, 'Failed asserting that array contains the given key');
        $this->assertEquals($value, $haystack[$key], 'Failed asserting that the array key equals the given value');
    }

    protected function setUp(): void
    {
        parent::setUp();

        DB::connection()->getSchemaBuilder()->disableForeignKeyConstraints();

        Config::set('filesystems.disks.images.root', __DIR__.'/../storage/app/tests');
        Config::set('filesystems.disks.images.url', __DIR__.'/../storage/app/tests');

        Storage::fake();
    }
}
