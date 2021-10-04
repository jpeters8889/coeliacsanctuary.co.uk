<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Products;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopProductVariantTest extends TestCase
{
    private ShopProductVariant $variant;

    private ShopProduct $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class), 'prices')
            ->create();

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->create();
    }

    /** @test */
    public function itHasAProduct()
    {
        $this->assertEquals(1, $this->variant->product()->count());
    }

    /** @test */
    public function itHasAPrice()
    {
        $this->assertEquals(1, $this->product->prices()->count());
        $this->assertEquals(ShopProductPrice::query()->first()->price, $this->product->prices()->first()->price);
    }

    /** @test */
    public function itGetsTheCurrentPrice()
    {
        $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->create([
                'price' => 500,
                'start_at' => Carbon::now()->subMinutes(30)->toDateTimeString(),
            ]);

        $this->assertEquals(500, $this->product->currentPrice);

        $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->create([
                'price' => 600,
                'start_at' => Carbon::now()->subMinutes(20)->toDateTimeString(),
            ]);

        $this->assertEquals(600, $this->product->fresh()->currentPrice);

        $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->onSale()
            ->create([
                'price' => 300,
                'start_at' => Carbon::now()->subMinutes(10)->toDateTimeString(),
            ]);

        $this->assertEquals(300, $this->product->fresh()->currentPrice);

        $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->onSale()
            ->create([
                'price' => 100,
                'start_at' => Carbon::now()->subMinutes(20)->toDateTimeString(),
                'end_at' => Carbon::now()->subMinutes(5)->toDateTimeString(),
            ]);

        $this->assertEquals(300, $this->product->fresh()->currentPrice);
    }

    /** @test */
    public function itDoesntLoadASalePriceWhenOneIsntSet()
    {
        $this->assertEquals(1, $this->product->prices()->count());
        $this->assertNull($this->product->salePrice);
    }

    /** @test */
    public function itLoadsThePreviousPriceIfAProductIsOnSale()
    {
        $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->create([
                'price' => 500,
                'start_at' => Carbon::now()->subMinutes(20)->toDateTimeString(),
            ]);

        $this->assertEquals(500, $this->product->currentPrice);
        $this->assertNull($this->product->oldPrice);

        $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->onSale()
            ->create([
                'price' => 250,
                'start_at' => Carbon::now()->subMinutes(10)->toDateTimeString(),
            ]);

        $this->assertEquals(250, $this->product->fresh()->currentPrice);
        $this->assertEquals(500, $this->product->fresh()->oldPrice);
    }
}
