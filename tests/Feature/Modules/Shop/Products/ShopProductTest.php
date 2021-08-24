<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Products;

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
    public function itErrorsWhenLoadingANonExistentProduct()
    {
        $this->get('/shop/product/foo')->assertStatus(404);
    }

    /** @test */
    public function itErrorsIfTheProductDoesntHaveAVariant()
    {
        $product = $this->createProduct($this->category);

        $this->get('/shop/product/'.$product->slug)->assertStatus(404);
    }

    /** @test */
    public function itLoadsThePage()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertStatus(200);
    }

    /** @test */
    public function itLoadsTheProductImageEndpoint()
    {
        $this->get('/api/shop/product/'.$this->product->id.'/images')->assertStatus(200);
    }

    /** @test */
    public function itHasTheProductTitle()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertSee($this->product->title, false);
    }

    /** @test */
    public function itHasTheProductShortDescription()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertSee($this->product->description, false);
    }

    /** @test */
    public function itHasTheProductLongDescription()
    {
        $this->get('/shop/product/'.$this->product->slug)->assertSee($this->product->long_description, false);
    }

    /** @test */
    public function itHasTheAddToBasketComponent()
    {
        $this->get('/shop/product/'.$this->product->slug)
            ->assertSee('<shop-product-add-basket :product-id="'.$this->product->id, false);
    }
}
