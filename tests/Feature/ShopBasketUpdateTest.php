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
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopBasketUpdateTest extends TestCase
{
    use RefreshDatabase;
    use CreateVariant;
    use CreateProduct;
    use WithFaker;

    private Store $session;
    private Basket $basket;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();

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
        return $this->put('/api/shop/basket', array_merge([
            'product' => $this->product->id,
            'variant' => $this->variant->id,
            'action' => 'increase',
        ], $params));
    }

    /** @test */
    public function it_errors_when_a_product_isnt_sent()
    {
        $this->makeRequest(['product' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_an_unknown_product_id()
    {
        $this->makeRequest(['product' => 'foo'])->assertStatus(422);
        $this->makeRequest(['product' => 2])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_a_product_with_no_live_variants()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_an_item_without_a_variant_id()
    {
        $this->makeRequest(['variant' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_an_unknown_variant_id()
    {
        $this->makeRequest(['variant' => 'foo'])->assertStatus(422);
        $this->makeRequest(['variant' => 2])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_a_variant_that_isnt_live()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_a_variant_that_doesnt_belong_to_the_product()
    {
        $product = $this->createProduct();
        $variant = $this->createVariant($product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->makeRequest(['variant' => $variant->id])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_not_sending_an_action()
    {
        $this->makeRequest(['action' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_sending_an_unknown_action()
    {
        $this->makeRequest(['action' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_update_a_product_that_isnt_in_the_basket()
    {
        $product = $this->createProduct();
        $variant = $this->createVariant($product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->basket->items()->add($product, $variant);

        $this->makeRequest()
            ->assertStatus(400)
            ->assertJson(['error' => 'Item isn\'t available in your basket']);
    }

    /** @test */
    public function it_errors_when_trying_to_increase_quantity_when_none_is_available()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->variant->update(['quantity' => 0]);

        $this->makeRequest()
            ->assertStatus(400)
            ->assertJson(['error' => 'Sorry, this product is out of stock']);
    }

    /** @test */
    public function it_increases_the_quantity()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $item = ShopOrderItem::query()->first();

        $this->assertEquals(1, $item->quantity);

        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(2, $item->fresh()->quantity);
    }

    /** @test */
    public function it_decreases_the_quantity()
    {
        $this->basket->items()->add($this->product, $this->variant, 2);

        $item = ShopOrderItem::query()->first();

        $this->assertEquals(2, $item->quantity);

        $this->makeRequest(['action' => 'decrease'])->assertStatus(200);

        $this->assertEquals(1, $item->fresh()->quantity);
    }

    /** @test */
    public function it_deletes_an_item_when_quantity_reaches_zero()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->assertNotEmpty(ShopOrderItem::query()->get());

        $this->makeRequest(['action' => 'decrease']);

        $this->assertEmpty(ShopOrderItem::query()->get());
    }
}
