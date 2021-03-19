<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop;

use Tests\TestCase;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;

class ShopCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheCountryList()
    {
        $this->get('/api/shop/countries')->assertStatus(200);
    }

    /** @test */
    public function itLoadsAListOfAllCountries()
    {
        $response = $this->get('/api/shop/countries')->json();

        ShopPostageCountry::query()->get()
            ->each(function (ShopPostageCountry $country) use ($response) {
                $this->assertContains([
                    'value' => $country->id,
                    'label' => $country->country,
                ], $response);
            });
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateWithoutACountry()
    {
        $this->post('/api/shop/countries')->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithAnUnknownCountry()
    {
        $this->post('/api/shop/countries', ['country' => 'foo'])->assertStatus(422);
        $this->post('/api/shop/countries', ['country' => 999])->assertStatus(422);
        $this->post('/api/shop/countries', ['country' => 0])->assertStatus(422);
        $this->post('/api/shop/countries', ['country' => -1])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToDoAValidUpdateWhenABasketDoesntExist()
    {
        $this->post('/api/shop/countries', ['country' => 2])->assertStatus(400);
    }

    /** @test */
    public function itReturnsSuccessWithAValidUpdate()
    {
        resolve(Basket::class)->create();

        $this->post('/api/shop/countries', ['country' => 2])->assertStatus(200);
    }

    /** @test */
    public function itUpdatesTheCountry()
    {
        resolve(Basket::class)->create();

        /** @var ShopOrder $order */
        $order = ShopOrder::query()->first();

        $this->assertEquals(1, $order->postage_country_id);

        $this->post('/api/shop/countries', ['country' => 2]);

        $this->assertEquals(2, $order->fresh()->postage_country_id);
    }
}
