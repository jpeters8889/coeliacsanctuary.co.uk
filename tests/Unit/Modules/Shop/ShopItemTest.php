<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopItemTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;
    use CreateProduct;
    use CreateVariant;

    /** @test */
    public function itHasAProduct()
    {
        /* @var ShopOrder $order */
        $this->createOrder();

        /** @var ShopProduct $product */
        $product = $this->createProduct();

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        /** @var ShopProductVariant $variant */
        $variant = $this->createVariant($product);

        /** @var ShopOrderItem $item */
        $item = factory(ShopOrderItem::class)->make([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'product_title' => $product->title,
            'product_price' => $product->currentPrice,
        ]);

        $this->assertSame($item->product->title, $product->title);
        $this->assertSame($item->product->currentPrice, $product->currentPrice);
    }
}
