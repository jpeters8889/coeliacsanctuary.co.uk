<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Illuminate\Support\Collection;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\CreateCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopProductTest extends TestCase
{
    use RefreshDatabase;
    use CreateCategory;
    use CreateProduct;
    use CreateVariant;
    use HasImages;

    /** @var ShopCategory */
    private $category;

    /** @var ShopProduct */
    private $product;

    /** @var ShopProductVariant */
    private $variant;

    /** @var Collection */
    private $images;

    /** @var ShopProductPrice */
    private $price;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = $this->createCategory();
        $this->product = $this->createProduct($this->category);
        $this->variant = $this->createVariant($this->product, ['live' => true, 'quantity' => 15]);
        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
        $this->price = factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);
    }

    /** @test */
    public function it_errors_when_loading_a_non_existent_product()
    {
        $this->get('/shop/product/foo')->assertStatus(404);
    }

    /** @test */
    public function it_errors_if_the_product_doesnt_have_a_variant()
    {
        $product = $this->createProduct($this->category);

        $this->get('/shop/product/'.$product->slug)->assertStatus(404);
    }

    /** @test */
    public function it_loads_the_page()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertStatus(200);
    }

    /** @test */
    public function it_loads_the_product_image_endpoint()
    {
        $this->get('/api/shop/product/'.$this->product->id.'/images')->assertStatus(200);
    }

    /** @test */
    public function it_has_the_product_title()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertSee($this->product->title, false);
    }

    /** @test */
    public function it_has_the_product_short_description()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertSee($this->product->description, false);
    }

    /** @test */
    public function it_has_the_product_long_description()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertSee($this->product->long_description, false);
    }

    /** @test */
    public function it_has_the_images_component()
    {
        $this->get('/shop/product/'.$this->product->slug)
            ->assertSee('<product-images :product-id="'.$this->product->id, false);
    }

    /** @test */
    public function it_has_the_add_to_basket_component()
    {
        $this->get('/shop/product/'.$this->product->slug)
            ->assertSee('<product-add-basket :product-id="'.$this->product->id, false);
    }
}
