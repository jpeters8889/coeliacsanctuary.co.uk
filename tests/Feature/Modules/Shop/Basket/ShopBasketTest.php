<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Basket;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Illuminate\Session\Store;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Models\ShopDiscountCodeType;

class ShopBasketTest extends TestCase
{
    use HasImages;

    private Store $session;
    private Basket $basket;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
            ->create()
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->create();
    }

    /** @test */
    public function itLoadsTheSummaryEndpoint()
    {
        $this->get('/api/shop/basket')
            ->assertStatus(200)
            ->assertJsonStructure(['items']);
    }

    /** @test */
    public function itShows0ItemsWhenTheresNothingInTheBasket()
    {
        $this->get('/api/shop/basket')->assertJson(['items' => 0]);
    }

    /** @test */
    public function itShowsTheNumberOfItemsInTheBasket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket')->assertJson(['items' => 1]);
    }

    /** @test */
    public function itLoadsTheBasketSummaryPage()
    {
        $this->get('/api/shop/basket/summary')->assertStatus(200);
    }

    /** @test */
    public function itLoadsTheBasketSummaryPageInTheCorreectFormat()
    {
        $this->get('/api/shop/basket/summary')
            ->assertJsonStructure([
                'items',
                'subtotal',
            ]);
    }

    /** @test */
    public function itReturnsAnEmptyDatasetWhenThereIsNoItems()
    {
        $this->get('/api/shop/basket/summary')
            ->assertJson([
                'items' => [],
                'subtotal' => 0,
            ]);
    }

    /** @test */
    public function itDisplaysTheItemDataInTheCorrectFormatWhenThereIsAnItemInTheBasket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonStructure([
                'items' => [[
                    'quantity',
                    'product_price',
                    'subtotal',
                    'product' => [
                        'id',
                        'title',
                        'link',
                        'first_image',
                        'price',
                    ],
                    'variant' => [
                        'id',
                        'product_id',
                        'title',
                    ],
                ]],
                'subtotal',
            ]);
    }

    /** @test */
    public function itLoadsAnItemsDetailsWhenItIsInTheBasket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(ShopOrderItem::query()->with('product', 'variant')->first()->toArray());
    }

    /** @test */
    public function itLoadsTheSubtotal()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['subtotal' => 500]);

        $product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 250]), 'prices')
            ->create()
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $variant = $this->build(ShopProductVariant::class)
            ->in($product)
            ->create();

        $this->basket->items()->add($product, $variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['subtotal' => 750]);
    }

    /** @test */
    public function itShowsThePostagePrice()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['postage' => 150]);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['subtotal' => 500]);

        $product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 250]), 'prices')
            ->create(['shipping_method_id' => 1])
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $variant = $this->build(ShopProductVariant::class)
            ->in($product)
            ->create(['weight' => 100]);

        $this->basket->items()->add($product, $variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['postage' => 250]);
    }

    /** @test */
    public function itShowsTheCountry()
    {
        $this->get('/api/shop/basket/summary')->assertJsonFragment(['country' => 1]);
    }

    /** @test */
    public function itShowsTheTotal()
    {
        $this->get('/api/shop/basket/summary')->assertJsonStructure(['total']);

        $this->basket->items()->add($this->product, $this->variant);

        $response = $this->get('/api/shop/basket/summary')->json();

        $total = $response['subtotal'] + $response['postage'];

        $this->assertEquals($total, $response['total']);
    }

    /** @test */
    public function itShowsTheDiscount()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['discount' => []])
            ->assertJsonFragment(['total' => 650]);

        /** @var ShopDiscountCode $code */
        $code = $this->build(ShopDiscountCode::class)
            ->percentageDiscount()
            ->state(['code' => 'foo', 'name' => 'Foo Discount'])
            ->create();

        // invalid code
        $this->withSession(['basket_discount_code' => 'foobar']);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['discount' => []])
            ->assertJsonFragment(['total' => 650]);

        // valid code
        $this->withSession(['basket_discount_code' => 'foo']);

        $request = $this->get('/api/shop/basket/summary');

        $this->assertNotEmpty($discountJson = $request->json('discount'));

        $keys = ['code', 'name', 'deduction'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $discountJson);
        }

        $this->assertEquals('foo', $discountJson['code']);
        $this->assertEquals('Foo Discount', $discountJson['name']);
        $this->assertEquals($code->calculateDeduction(500), $discountJson['deduction']);
        $this->assertEquals(50, $discountJson['deduction']);

        // 10 percent discount from 500 total plus 150 postage
        $request->assertJsonFragment(['total' => 600]);
    }
}
