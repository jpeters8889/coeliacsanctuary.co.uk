<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Illuminate\Session\Store;
use Coeliac\Common\Models\Image;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Basket\Basket;
use Tests\Traits\Shop\HasPostageOptions;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Models\ShopDiscountCodeType;

class ShopBasketTest extends TestCase
{
    use RefreshDatabase;
    use CreateVariant;
    use CreateProduct;
    use HasPostageOptions;
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

        $this->product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $this->variant = $this->createVariant($this->product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $this->setupPostage();
    }

    /** @test */
    public function it_loads_the_summary_endpoint()
    {
        $this->get('/api/shop/basket')
            ->assertStatus(200)
            ->assertJsonStructure(['items']);
    }

    /** @test */
    public function it_shows_0_items_when_theres_nothing_in_the_basket()
    {
        $this->get('/api/shop/basket')->assertJson(['items' => 0]);
    }

    /** @test */
    public function it_shows_the_number_of_items_in_the_basket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket')->assertJson(['items' => 1]);
    }

    /** @test */
    public function it_loads_the_basket_summary_page()
    {
        $this->get('/api/shop/basket/summary')->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_basket_summary_page_in_the_correect_format()
    {
        $this->get('/api/shop/basket/summary')
            ->assertJsonStructure([
                'items',
                'subtotal',
            ]);
    }

    /** @test */
    public function it_returns_an_empty_dataset_when_there_is_no_items()
    {
        $this->get('/api/shop/basket/summary')
            ->assertJson([
                'items' => [],
                'subtotal' => 0,
            ]);
    }

    /** @test */
    public function it_displays_the_item_data_in_the_correct_format_when_there_is_an_item_in_the_basket()
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
    public function it_loads_an_items_details_when_it_is_in_the_basket()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(ShopOrderItem::query()->with('product', 'variant')->first()->toArray());
    }

    /** @test */
    public function it_loads_the_subtotal()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['subtotal' => 500]);

        $product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $variant = $this->createVariant($product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 250,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $this->basket->items()->add($product, $variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['subtotal' => 750]);
    }

    /** @test */
    public function it_shows_the_postage_price()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['postage' => 150]);

        $product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $variant = $this->createVariant($product, ['live' => true, 'weight' => 110]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 250,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $this->basket->items()->add($product, $variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['postage' => 250]);
    }

    /** @test */
    public function it_shows_the_country()
    {
        $this->get('/api/shop/basket/summary')->assertJsonFragment(['country' => 1]);
    }

    /** @test */
    public function it_shows_the_total()
    {
        $this->get('/api/shop/basket/summary')->assertJsonStructure(['total']);

        $this->basket->items()->add($this->product, $this->variant);

        $response = $this->get('/api/shop/basket/summary')->json();

        $total = $response['subtotal'] + $response['postage'];

        $this->assertEquals($total, $response['total']);
    }

    /** @test */
    public function it_shows_the_discount()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->get('/api/shop/basket/summary')
            ->assertJsonFragment(['discount' => []])
            ->assertJsonFragment(['total' => 650]);

        /** @var ShopDiscountCode $code */
        $code = factory(ShopDiscountCode::class)->create([
            'code' => 'foo',
            'name' => 'Foo Discount',
            'type_id' => ShopDiscountCodeType::PERCENTAGE,
            'deduction' => 10,
            'start_at' => Carbon::now()->subHour(),
        ]);

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
