<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Illuminate\Support\Facades\Event;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopBasketClosedEventTest extends TestCase
{
    use MakesShopOrders;
    use CreateProduct;
    use CreateVariant;
    use RefreshDatabase;

    protected ShopOrder $basket;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setupOrders();

        $product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $variant = $this->createVariant($product, ['weight' => 10, 'quantity' => 0]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->basket = ShopOrder::query()->create([
            'state_id' => ShopOrderState::STATE_BASKET,
            'token' => Str::random(8),
            'postage_country_id' => 1,
        ]);

        ShopOrderItem::query()->create([
            'order_id' => 1,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 5,
            'product_title' => $product->title,
            'product_price' => $product->currentPrice,
        ]);
    }

    /** @test */
    public function it_resets_an_items_stock_when_a_basket_is_closed()
    {
        $this->assertEquals(0, ShopProductVariant::query()->first()->quantity);

        Event::dispatch(new BasketClosed($this->basket));

        $this->assertEquals(5, ShopProductVariant::query()->first()->quantity);
    }
}
