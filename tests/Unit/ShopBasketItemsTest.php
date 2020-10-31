<?php

declare(strict_types=1);

namespace Tests\Unit;

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
use Coeliac\Modules\Shop\Exceptions\BasketException;

class ShopBasketItemsTest extends TestCase
{
    use CreateProduct;
    use CreateVariant;
    use RefreshDatabase;

    private Store $session;
    private Basket $basket;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);

        $this->basket->create();

        $this->product = $this->createProduct();
        $this->variant = $this->createVariant($this->product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);
    }

    /** @test */
    public function it_always_loads_the_same_instance_of_the_items_class()
    {
        $items = $this->basket->items();

        $this->assertEquals($items, $this->basket->items());
    }

    /** @test */
    public function it_will_error_when_trying_to_add_a_product_that_isnt_live()
    {
        $this->variant->update(['live' => false]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Product not found');

        $this->basket->items()->add($this->product, $this->variant);

        $this->assertEmpty($this->basket->model()->items);
    }

    /** @test */
    public function it_creates_a_basket_if_one_doesnt_exist()
    {
        $currentBasket = $this->basket->model();
        $this->session->remove('basket_token');

        $this->basket->items()->add($this->product, $this->variant);

        $this->assertFalse($this->basket->model()->is($currentBasket));
    }

    /** @test */
    public function it_adds_an_item_to_the_basket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->assertCount(1, $this->basket->model()->items);
        $this->assertTrue($this->basket->model()->items[0]->is(ShopOrderItem::query()->first()));
    }

    /** @test */
    public function it_adds_the_quantity_specified()
    {
        $this->variant->update(['quantity' => 2]);

        $this->basket->items()->add($this->product, $this->variant, 2);

        $this->assertEquals(2, ShopOrderItem::query()->first()->quantity);
        $this->assertEquals(0, $this->variant->quantity);
    }

    /** @test */
    public function it_errors_if_an_item_is_already_in_the_basket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Item is already in your basket');

        $this->basket->items()->add($this->product, $this->variant);
    }

    /** @test */
    public function it_errors_if_the_product_is_not_in_stock()
    {
        $this->variant->update(['quantity' => 0]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Product Variant is out of stock');

        $this->basket->items()->add($this->product, $this->variant);
    }

    /** @test */
    public function it_errors_when_trying_to_add_more_items_than_is_available()
    {
        $this->variant->update(['quantity' => 1]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Product Variant doesn\'t have enough quantity available');

        $this->basket->items()->add($this->product, $this->variant, 2);
    }

    /** @test */
    public function it_errors_when_trying_to_alter_an_item_when_no_basket_is_open()
    {
        $this->session->remove('basket_token');

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('No open basket');

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('No open basket');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);
    }

    /** @test */
    public function it_errors_when_trying_to_alter_an_item_that_isnt_in_the_basket()
    {
        $product = $this->createProduct();
        $variant = $this->createVariant($product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Item isn\'t available in the basket');

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Item isn\'t available in the basket');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);
    }

    /** @test */
    public function it_decreases_an_items_quantity()
    {
        $this->variant->update(['quantity' => 2]);

        $this->basket->items()->add($this->product, $this->variant, 2);

        /** @var ShopOrderItem $item */
        $item = ShopOrderItem::query()->first();

        $this->assertEquals(2, $item->quantity);
        $this->assertEquals(0, $this->variant->fresh()->quantity);

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->assertEquals(1, $item->fresh()->quantity);
        $this->assertEquals(1, $this->variant->fresh()->quantity);
    }

    /** @test */
    public function it_increases_an_items_quantity()
    {
        $this->variant->update(['quantity' => 2]);

        $this->basket->items()->add($this->product, $this->variant, 1);

        /** @var ShopOrderItem $item */
        $item = ShopOrderItem::query()->first();

        $this->assertEquals(1, $item->quantity);
        $this->assertEquals(1, $this->variant->fresh()->quantity);

        $this->basket->items()->increaseQuantity($this->product, $this->variant);

        $this->assertEquals(2, $item->fresh()->quantity);
        $this->assertEquals(0, $this->variant->fresh()->quantity);
    }

    /** @test */
    public function it_errors_when_trying_to_increase_an_item_when_the_stock_doesnt_allow_it()
    {
        $this->variant->update(['quantity' => 1]);
        $this->basket->items()->add($this->product, $this->variant, 1);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Product Variant is out of stock');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);

        $this->variant->update(['quantity' => 1]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Product Variant is out of stock');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);
    }

    /** @test */
    public function it_deletes_an_item_when_decreasing_quantity_when_the_quantity_is_one()
    {
        $this->variant->update(['quantity' => 1]);
        $this->basket->items()->add($this->product, $this->variant, 1);

        $this->assertNotEmpty($this->basket->model()->items);

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->assertEmpty($this->basket->model()->items);
        $this->assertEquals(1, $this->variant->fresh()->quantity);
    }
}
