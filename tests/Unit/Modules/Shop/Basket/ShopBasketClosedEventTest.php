<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Basket;

use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopBasketClosedEventTest extends TestCase
{
    protected ShopOrder $basket;

    protected function setUp(): void
    {
        parent::setUp();

        $product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create();

        $variant = $this->build(ShopProductVariant::class)
            ->in($product)
            ->create(['weight' => 10, 'quantity' => 0]);

        $this->basket = $this->build(ShopOrder::class)->asBasket()->create();

        $this->build(ShopOrderItem::class)
            ->add(5, $variant)
            ->to($this->basket)
            ->create();
    }

    /** @test */
    public function itResetsAnItemsStockWhenABasketIsClosed()
    {
        $this->assertEquals(0, ShopProductVariant::query()->first()->quantity);

        Event::dispatch(new BasketClosed($this->basket));

        $this->assertEquals(5, ShopProductVariant::query()->first()->quantity);
    }
}
