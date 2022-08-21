<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\TestCase;

class ShopItemTest extends TestCase
{
    /** @test */
    public function itHasAProduct()
    {
        $item = $this->build(ShopOrderItem::class)
            ->to($this->build(ShopOrder::class)
            ->has($this->build(ShopPayment::class), 'payment')
            ->create())
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $product = ShopProduct::query()->first();

        $this->assertSame($item->product->title, $product->title);
        $this->assertSame($item->product->currentPrice, $product->currentPrice);
    }
}
