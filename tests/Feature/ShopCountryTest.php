<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;

class ShopCountryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_country_list()
    {
        $this->get('/api/shop/countries')->assertStatus(200);
    }

    /** @test */
    public function it_loads_a_list_of_all_countries()
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
    public function it_errors_when_trying_to_update_without_a_country()
    {
        $this->post('/api/shop/countries')->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_unknown_country()
    {
        $this->post('/api/shop/countries', ['country' => 'foo'])->assertStatus(422);
        $this->post('/api/shop/countries', ['country' => 999])->assertStatus(422);
        $this->post('/api/shop/countries', ['country' => 0])->assertStatus(422);
        $this->post('/api/shop/countries', ['country' => -1])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_do_a_valid_update_when_a_basket_doesnt_exist()
    {
        $this->post('/api/shop/countries', ['country' => 2])->assertStatus(400);
    }

    /** @test */
    public function it_returns_success_with_a_valid_update()
    {
        resolve(Basket::class)->create();

        $this->post('/api/shop/countries', ['country' => 2])->assertStatus(200);
    }

    /** @test */
    public function it_updates_the_country()
    {
        resolve(Basket::class)->create();

        /** @var ShopOrder $order */
        $order = ShopOrder::query()->first();

        $this->assertEquals(1, $order->postage_country_id);

        $this->post('/api/shop/countries', ['country' => 2]);

        $this->assertEquals(2, $order->fresh()->postage_country_id);
    }
}
