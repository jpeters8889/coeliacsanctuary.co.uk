<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Tests\Mocks\PostcodeLookupMock;
use Coeliac\Modules\Shop\PostcodeLookup\Service;
use Coeliac\Modules\Shop\PostcodeLookup\GetAddress\Parser;

class ShopPostcodeLookupTest extends TestCase
{
    private Service $postcodeService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postcodeService = new PostcodeLookupMock(new Client(), new Parser());

        $this->app->singleton(Service::class, function () {
            return $this->postcodeService;
        });
    }

    /** @test */
    public function itReturnsACollection()
    {
        $this->assertInstanceOf(Collection::class, $this->postcodeService->lookup('cw15ew'));
    }

    /** @test */
    public function itReturnsDataWithTheCorrectKeys()
    {
        $lookup = $this->postcodeService->lookup('cw15ew')->first();
        $keys = ['address_1', 'address_2', 'address_3', 'town', 'county', 'postcode', 'friendly', 'house_number'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $lookup);
        }
    }

    /** @test */
    public function itPopulatesAllFieldsWhenAnAddressContainsAllData()
    {
        $lookup = $this->postcodeService->lookup('st42rw')->first();

        foreach ($lookup as $value) {
            $this->assertNotNull($value);
        }
    }
}
