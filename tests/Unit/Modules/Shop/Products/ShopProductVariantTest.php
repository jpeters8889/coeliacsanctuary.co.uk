<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Products;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopProductVariantTest extends TestCase
{
    use RefreshDatabase;
    use CreateVariant;
    use CreateProduct;

    /**
     * @var ShopProductVariant
     */
    private $variant;

    /**
     * @var ShopProduct
     */
    private $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = $this->createProduct();
        $this->variant = $this->createVariant($this->product);
    }

    /** @test */
    public function itHasAProduct()
    {
        $this->assertEquals(1, $this->variant->product()->count());
    }

    /** @test */
    public function itHasAPrice()
    {
        $price = factory(ShopProductPrice::class)->create(['product_id' => $this->product->id]);

        $this->assertEquals(1, $this->product->prices()->count());
        $this->assertEquals($price->price, $this->product->prices()->first()->price);
    }

    /** @test */
    public function itGetsTheCurrentPrice()
    {
        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->assertEquals(500, $this->product->currentPrice);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 600,
            'start_at' => Carbon::now()->subMinutes(50)->toDateTimeString(),
        ]);

        $this->assertEquals(600, $this->product->fresh()->currentPrice);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 300,
            'sale_price' => true,
            'start_at' => Carbon::now()->subMinutes(30)->toDateTimeString(),
        ]);

        $this->assertEquals(300, $this->product->fresh()->currentPrice);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->variant->id,
            'price' => 100,
            'sale_price' => true,
            'start_at' => Carbon::now()->subMinutes(30)->toDateTimeString(),
            'end_at' => Carbon::now()->subMinutes(10)->toDateTimeString(),
        ]);

        $this->assertEquals(300, $this->product->fresh()->currentPrice);
    }

    /** @test */
    public function itDoesntLoadASalePriceWhenOneIsntSet()
    {
        factory(ShopProductPrice::class)->create(['product_id' => $this->product->id]);

        $this->assertEquals(1, $this->product->prices()->count());
        $this->assertNull($this->product->salePrice);
    }

    /** @test */
    public function itLoadsThePreviousPriceIfAProductIsOnSale()
    {
        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->assertEquals(500, $this->product->currentPrice);
        $this->assertNull($this->product->oldPrice);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 250,
            'sale_price' => true,
            'start_at' => Carbon::now()->subMinutes(30)->toDateTimeString(),
        ]);

        $this->assertEquals(250, $this->product->fresh()->currentPrice);
        $this->assertEquals(500, $this->product->fresh()->oldPrice);
    }
}
