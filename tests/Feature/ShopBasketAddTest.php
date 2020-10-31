<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Session\Store;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopBasketAddTest extends TestCase
{
    use RefreshDatabase;
    use CreateVariant;
    use CreateProduct;

    private Store $session;
    private Basket $basket;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);

        $this->product = $this->createProduct();
        $this->variant = $this->createVariant($this->product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);
    }

    protected function makeRequest($params = [])
    {
        return $this->post('/api/shop/basket', array_merge([
            'product_id' => $this->product->id,
            'variant_id' => $this->variant->id,
            'quantity' => 1,
        ], $params));
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_item_without_a_product_id()
    {
        $this->makeRequest(['product_id' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_unknown_product_id()
    {
        $this->makeRequest(['product_id' => 'foo'])->assertStatus(422);
        $this->makeRequest(['product_id' => 2])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_a_product_with_no_live_variants()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_item_without_a_variant_id()
    {
        $this->makeRequest(['variant_id' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_unknown_variant_id()
    {
        $this->makeRequest(['variant_id' => 'foo'])->assertStatus(422);
        $this->makeRequest(['variant_id' => 2])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_a_variant_that_isnt_live()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_a_variant_that_doesnt_belong_to_the_product()
    {
        $product = $this->createProduct();
        $variant = $this->createVariant($product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->makeRequest(['variant_id' => $variant->id])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_a_variant_that_isnt_in_stock()
    {
        $this->variant->update(['quantity' => 0]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_item_without_a_quantity()
    {
        $this->makeRequest(['quantity' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_item_with_an_invalid_quantity()
    {
        $this->makeRequest(['quantity' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_add_an_item_with_a_negative_quantiy()
    {
        $this->makeRequest(['quantity' => 0])->assertStatus(422);
        $this->makeRequest(['quantity' => -1])->assertStatus(422);
    }

    /** @test */
    public function it_returns_success_when_sending_valid_date()
    {
        $this->makeRequest()
            ->assertStatus(200)
            ->assertJson(['data' => 'ok']);
    }

    /** @test */
    public function it_adds_the_item_to_the_basket()
    {
        $this->makeRequest();

        $this->assertCount(1, ShopOrderItem::query()->get());
        $this->assertTrue($this->product->is(ShopOrderItem::query()->first()->product));
        $this->assertTrue($this->variant->is(ShopOrderItem::query()->first()->variant));
    }
}
