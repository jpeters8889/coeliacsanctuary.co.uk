<?php

declare(strict_types=1);

namespace Tests\Unit;

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
    public function it_returns_a_collection()
    {
        $this->assertInstanceOf(Collection::class, $this->postcodeService->lookup('cw15ew'));
    }

    /** @test */
    public function it_returns_data_with_the_correct_keys()
    {
        $lookup = $this->postcodeService->lookup('cw15ew')->first();
        $keys = ['address_1', 'address_2', 'address_3', 'town', 'county', 'postcode', 'friendly', 'house_number'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $lookup);
        }
    }

    /** @test */
    public function it_populates_all_fields_when_an_address_contains_all_data()
    {
        $lookup = $this->postcodeService->lookup('st42rw')->first();

        foreach ($lookup as $value) {
            $this->assertNotNull($value);
        }
    }
}
