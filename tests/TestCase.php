<?php

declare(strict_types=1);

namespace Tests;

use Coeliac\Base\Models\BaseModel;
use Database\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Scout\Builder;
use Tests\Mocks\MockScoutBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected function assertArrayHas(int|string $key, mixed $value, array $haystack): void
    {
        $this->assertArrayHasKey($key, $haystack, 'Failed asserting that array contains the given key');
        $this->assertEquals($value, $haystack[$key], 'Failed asserting that the array key equals the given value');
    }

    protected function assertArrayHasStructure(array $keys, array $haystack): void
    {
        $hasStructure = true;
        $failed = [];

        foreach ($keys as $key) {
            if (!isset($haystack[$key]) && $haystack[$key] !== null) {
                $hasStructure = false;
                $failed[] = $key;
            }
        }

        $this->assertTrue(
            $hasStructure,
            'Failed asserting that the iterable has the given structure, ['.implode(', ', $failed).'] missing.'
        );
    }

    protected function build(string $what): Factory
    {
        return Factory::factoryForModel($what);
    }

    /**
     * @param string $what
     * @param array $attributes
     * @return BaseModel
     */
    protected function create(string $what, array $attributes = []): Model
    {
        return $this->build($what)->create($attributes);
    }

    protected function setUp(): void
    {
        parent::setUp();

        DB::connection()->getSchemaBuilder()->disableForeignKeyConstraints();

        Config::set('filesystems.disks.images.root', __DIR__.'/../storage/app/tests');
        Config::set('filesystems.disks.images.url', __DIR__.'/../storage/app/tests');

        Storage::fake();

        $this->seed();
    }

    protected function setUpScout(): void
    {
        $this->app->bind(Builder::class, MockScoutBuilder::class);
    }

    protected function asAdmin(): self
    {
        $this->actingAs(admin_user());

        return $this;
    }
}
