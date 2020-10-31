<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Session\Store;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Basket\Basket;
use Tests\Traits\Shop\HasPostageOptions;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Exceptions\BasketException;

class ShopBasketPostageTest extends TestCase
{
    use CreateProduct;
    use CreateVariant;
    use RefreshDatabase;
    use HasPostageOptions;

    private Store $session;
    private Basket $basket;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);

        $this->basket->create();

        $this->setupPostage();
    }

    /**
     * @test
     * @dataProvider postageOptions
     */
    public function it_calculates_postage($expected, $shippingMethod, $productWeight)
    {
        $product = $this->createProduct(null, ['shipping_method_id' => $shippingMethod]);
        $variant = $this->createVariant($product, ['live' => true, 'weight' => $productWeight]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->basket->items()->add($product, $variant);

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
    public function it_errors_when_the_postage_cant_be_found()
    {
        $product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $variant = $this->createVariant($product, ['live' => true, 'weight' => 300]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->basket->items()->add($product, $variant);

        $this->expectException(BasketException::class);
        $this->expectExceptionMessage("Can't find postage option");

        $this->basket->postage()->calculate();
    }
}
