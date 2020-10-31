<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\CreateCategory;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopCategoryTest extends TestCase
{
    use RefreshDatabase;
    use CreateCategory;
    use CreateProduct;
    use CreateVariant;
    use HasImages;

    /**
     * @var ShopCategory
     */
    private $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = $this->createCategory();
        $this->category->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_CATEGORY);
    }

    /** @test */
    public function it_doesnt_load_a_page_with_no_products()
    {
        $request = $this->get('/shop/'.$this->category->slug);

        $request->assertStatus(404);
    }

    /** @test */
    public function it_doesnt_load_page_with_no_live_products()
    {
        $product = $this->createProduct($this->category);
        $variant = $this->createVariant($product, ['live' => false]);

        $request = $this->get('/shop/'.$this->category->slug);

        $request->assertStatus(404);
    }

    /** @test */
    public function it_lists_products_on_the_page()
    {
        $this->withoutExceptionHandling();

        $product = $this->createProduct($this->category, ['title' => 'First Product']);
        $product2 = $this->createProduct($this->category, ['title' => 'Second Product']);

        $this->createVariant($product, ['live' => true]);
        $this->createVariant($product2, ['live' => true]);

        $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
        $product2->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $product2->id,
            'price' => 600,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $request = $this->get('/shop/'.$this->category->slug);

        $request->assertStatus(200);
        $request->assertSee($this->category->description, false);

        $request->assertSee('First Product', false);
        $request->assertSee('Second Product', false);
        $request->assertSee('£5.00', false);
        $request->assertSee('£6.00', false);

        $request->assertSee('Find out more', false);
        $request->assertSee('Add to Basket', false);
    }

    /** @test */
    public function it_displays_a_message_when_a_product_is_out_of_stock()
    {
        $product = $this->createProduct($this->category, ['title' => 'First Product']);
        $this->createVariant($product, ['live' => true, 'quantity' => 0]);

        $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $request = $this->get('/shop/'.$this->category->slug);

        $request->assertDontSee('Add to Basket');
        $request->assertSee('Out of stock', false);
    }

    /** @test */
    public function it_doesnt_show_add_to_basket_on_products_with_multiple_variants()
    {
        $product = $this->createProduct($this->category, ['title' => 'First Product']);
        $this->createVariant($product, ['live' => true]);
        $this->createVariant($product, ['live' => true]);

        $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $request = $this->get('/shop/'.$this->category->slug);

        $request->assertDontSee('Add to Basket');
    }
}
