<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Products;

use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;

class ShopProductsTest extends TestCase
{
    use HasImages;

    /** @test */
    public function itHasACategory()
    {
        $category = $this->create(ShopCategory::class);

        $product = $this->create(ShopProduct::class);
        $category->products()->attach($product);

        $this->assertEquals(1, $category->products()->count());
        $this->assertEquals($product->title, $category->products()->first()->title);
    }

    /** @test */
    public function itCanBelongToManyCategories()
    {
        [$category, $category2] = $this->build(ShopCategory::class)
            ->count(2)
            ->create();

        $product = $this->create(ShopProduct::class);

        $category->products()->attach($product);
        $category2->products()->attach($product);

        $this->assertEquals(2, $product->categories()->count());
    }

    /** @test */
    public function itHasAShippingMethod()
    {
        $product = $this->create(ShopProduct::class);

        $this->assertEquals(1, $product->shippingMethod()->count());
    }

    /** @test */
    public function itHasAVariant()
    {
        $product = $this->create(ShopProduct::class);

        $variant = $this->build(ShopProductVariant::class)
            ->in($product)
            ->create();

        $this->assertEquals(1, $product->variants()->count());
        $this->assertEquals($variant->title, $product->variants()->first()->title);
    }

    /** @test */
    public function itHasManyVariants()
    {
        $product = $this->create(ShopProduct::class);

        $this->build(ShopProductVariant::class)
            ->count(3)
            ->in($product)
            ->create();

        $this->assertEquals(3, $product->variants()->count());
    }

    /** @test */
    public function itHasAnImage()
    {
        /** @var ShopProduct $product */
        $product = $this->create(ShopProduct::class);

        $product->associateImage($this->makeImage());

        $this->assertEquals(1, $product->images()->count());
    }
}
