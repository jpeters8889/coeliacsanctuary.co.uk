<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Basket;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Session\Store;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Exceptions\BasketException;

class ShopBasketItemsTest extends TestCase
{
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

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create();

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->create();
    }

    /** @test */
    public function itAlwaysLoadsTheSameInstanceOfTheItemsClass()
    {
        $items = $this->basket->items();

        $this->assertEquals($items, $this->basket->items());
    }

    /** @test */
    public function itWillErrorWhenTryingToAddAProductThatIsntLive()
    {
        $this->variant->update(['live' => false]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('This product can\'t be found');

        $this->basket->items()->add($this->product, $this->variant);

        $this->assertEmpty($this->basket->model()->items);
    }

    /** @test */
    public function itCreatesABasketIfOneDoesntExist()
    {
        $currentBasket = $this->basket->model();
        $this->session->remove('basket_token');

        $this->basket->items()->add($this->product, $this->variant);

        $this->assertFalse($this->basket->model()->is($currentBasket));
    }

    /** @test */
    public function itAddsAnItemToTheBasket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->assertCount(1, $this->basket->model()->items);
        $this->assertTrue($this->basket->model()->items[0]->is(ShopOrderItem::query()->first()));
    }

    /** @test */
    public function itAddsTheQuantitySpecified()
    {
        $this->variant->update(['quantity' => 2]);

        $this->basket->items()->add($this->product, $this->variant, 2);

        $this->assertEquals(2, ShopOrderItem::query()->first()->quantity);
        $this->assertEquals(0, $this->variant->quantity);
    }

    /** @test */
    public function itErrorsIfAnItemIsAlreadyInTheBasket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('This item is already in your basket!');

        $this->basket->items()->add($this->product, $this->variant);
    }

    /** @test */
    public function itErrorsIfTheProductIsNotInStock()
    {
        $this->variant->update(['quantity' => 0]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Sorry, this product is out of stock');

        $this->basket->items()->add($this->product, $this->variant);
    }

    /** @test */
    public function itErrorsWhenTryingToAddMoreItemsThanIsAvailable()
    {
        $this->variant->update(['quantity' => 1]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Sorry, this product doesn\'t have enough quantity available');

        $this->basket->items()->add($this->product, $this->variant, 2);
    }

    /** @test */
    public function itErrorsWhenTryingToAlterAnItemWhenNoBasketIsOpen()
    {
        $this->session->remove('basket_token');

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('No basket found');

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('No basket found');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);
    }

    /** @test */
    public function itErrorsWhenTryingToAlterAnItemThatIsntInTheBasket()
    {
        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Item isn\'t available in your basket');

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Item isn\'t available in the basket');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);
    }

    /** @test */
    public function itDecreasesAnItemsQuantity()
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
    public function itIncreasesAnItemsQuantity()
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
    public function itErrorsWhenTryingToIncreaseAnItemWhenTheStockDoesntAllowIt()
    {
        $this->variant->update(['quantity' => 1]);
        $this->basket->items()->add($this->product, $this->variant, 1);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Sorry, this product is out of stock');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);

        $this->variant->update(['quantity' => 1]);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage('Sorry, this product is out of stock');

        $this->basket->items()->increaseQuantity($this->product, $this->variant);
    }

    /** @test */
    public function itDeletesAnItemWhenDecreasingQuantityWhenTheQuantityIsOne()
    {
        $this->variant->update(['quantity' => 1]);
        $this->basket->items()->add($this->product, $this->variant, 1);

        $this->assertNotEmpty($this->basket->model()->items);

        $this->basket->items()->decreaseQuantity($this->product, $this->variant);

        $this->assertEmpty($this->basket->model()->items);
        $this->assertEquals(1, $this->variant->fresh()->quantity);
    }
}
