<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Products;

use Coeliac\Common\Models\Image;
use Tests\TestCase;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\Traits\HasImages;

class ShopProductTest extends TestCase
{
    use HasImages;

    /** @var ShopCategory */
    private ShopCategory $category;

    /** @var ShopProduct */
    private ShopProduct $product;

    /** @var ShopProductVariant */
    private ShopProductVariant $variant;

    /** @var ShopProductPrice */
    private ShopProductPrice $price;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = $this->create(ShopCategory::class);

        $this->product = $this->create(ShopProduct::class);
        $this->product->categories()->attach($this->category);

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->state(['quantity' => 15])
            ->create();

        // here
        $this->price = $this->build(ShopProductPrice::class)
            ->in($this->product)
            ->state(['price' => 500])
            ->create();

        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
    }

    /** @test */
    public function itErrorsWhenLoadingANonExistentProduct()
    {
        $this->get('/shop/product/foo')->assertStatus(404);
    }

    /** @test */
    public function itErrorsIfTheProductDoesntHaveAVariant()
    {
        $product = $this->create(ShopProduct::class);
        $product->categories()->attach($this->category);

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
