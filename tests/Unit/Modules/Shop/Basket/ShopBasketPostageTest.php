<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Basket;

use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Exceptions\BasketException;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Session\Store;
use Tests\TestCase;

class ShopBasketPostageTest extends TestCase
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
            ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
            ->create();

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->create();
    }

    /**
     * @test
     * @dataProvider postageOptions
     */
    public function itCalculatesPostage($expected, $shippingMethod, $productWeight)
    {
        $this->product->update(['shipping_method_id' => $shippingMethod]);
        $this->variant->update(['weight' => $productWeight]);

        $this->basket->items()->add($this->product, $this->variant);

        $this->assertEquals($expected, $this->basket->postage()->calculate());
    }

    public function postageOptions()
    {
        return [
            [150, 1, 5],
            [150, 1, 50],
            [150, 1, 99],
            [150, 1, 100],
            [250, 1, 101],
            [250, 1, 150],
            [250, 1, 200],
        ];
    }

    /** @test */
    public function itErrorsWhenThePostageCantBeFound()
    {
        $this->variant->update(['weight' => 300]);

        $this->basket->items()->add($this->product, $this->variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage("Can't find postage option");

        $this->basket->postage()->calculate();
    }
}
