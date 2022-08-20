<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Categories;

use Coeliac\Common\Models\Image;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Tests\Traits\HasImages;

class ShopCategoryTest extends TestCase
{
    use HasImages;

    private ShopCategory $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = $this->create(ShopCategory::class)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_CATEGORY);
    }

    /** @test */
    public function itDoesntLoadAPageWithNoProducts()
    {
        $request = $this->get('/shop/' . $this->category->slug);

        $request->assertStatus(404);
    }

    /** @test */
    public function itDoesntLoadPageWithNoLiveProducts()
    {
        $this->category->products()->attach(
            $this->build(ShopProduct::class)
                ->has($this->build(ShopProductVariant::class)->notLive(), 'variants')
                ->create()
        );

        $request = $this->get('/shop/' . $this->category->slug);

        $request->assertStatus(404);
    }

    /** @test */
    public function itListsProductsOnThePage()
    {
        [$product, $product2] = $this->build(ShopProduct::class)
            ->count(2)
            ->has($this->build(ShopProductVariant::class), 'variants')
            ->state(new Sequence(
                ['title' => 'First Product'],
                ['title' => 'Second Product'],
            ))
            ->create()
            ->each(fn (ShopProduct $product) => $product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT));

        $this->category->products()->attach($product);
        $this->category->products()->attach($product2);

        $this->build(ShopProductPrice::class)
            ->in($product)
            ->create(['price' => 500]);

        $this->build(ShopProductPrice::class)
            ->in($product2)
            ->create(['price' => 600]);

        $this->get('/shop/' . $this->category->slug)
            ->assertStatus(200)
            ->assertSee($this->category->description, false)
            ->assertSee('First Product', false)
            ->assertSee('Second Product', false)
            ->assertSee('£5.00', false)
            ->assertSee('£6.00', false)
            ->assertSee('Find out more', false)
            ->assertSee('Add to Basket', false);
    }

    /** @test */
    public function itDisplaysAMessageWhenAProductIsOutOfStock()
    {
        $this->category->products()->attach(
            $this->build(ShopProduct::class)
                ->has($this->build(ShopProductVariant::class)->outOfStock(), 'variants')
                ->create()
        );

        $request = $this->get('/shop/' . $this->category->slug);

        $request->assertDontSee('Add to Basket');
        $request->assertSee('Out of stock', false);
    }

    /** @test */
    public function itDoesntShowAddToBasketOnProductsWithMultipleVariants()
    {
        $this->build(ShopProduct::class)
            ->has($this->build(ShopProductVariant::class)->outOfStock(), 'variants')
            ->has($this->build(ShopProductPrice::class), 'prices')
            ->create();

        $request = $this->get('/shop/' . $this->category->slug);

        $request->assertDontSee('Add to Basket');
    }
}
