<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Products;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\CreateCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopProductsTest extends TestCase
{
    use RefreshDatabase;
    use CreateProduct;
    use CreateCategory;
    use CreateVariant;
    use HasImages;

    /** @test */
    public function itHasACategory()
    {
        /**
         * @var ShopCategory
         */
        $category = $this->createCategory();

        /**
         * @var ShopProduct
         */
        $product = $this->createProduct($category);

        $this->assertEquals(1, $category->products()->count());
        $this->assertEquals($product->title, $category->products()->first()->title);
    }

    /** @test */
    public function itCanBelongToManyCategories()
    {
        /**
         * @var ShopCategory
         */
        $category = $this->createCategory();

        /**
         * @var ShopCategory
         */
        $category2 = $this->createCategory();

        /**
         * @var ShopProduct
         */
        $product = $this->createProduct($category);

        $category2->products()->attach($product);

        $this->assertEquals(2, $product->categories()->count());
    }

    /** @test */
    public function itHasAShippingMethod()
    {
        /**
         * @var ShopProduct
         */
        $product = $this->createProduct();

        $this->assertEquals(1, $product->shippingMethod()->count());
    }

    /** @test */
    public function itHasAVariant()
    {
        /**
         * @var ShopProduct
         */
        $product = $this->createProduct();

        $variant = $this->createVariant($product);

        $this->assertEquals(1, $product->variants()->count());
        $this->assertEquals($variant->title, $product->variants()->first()->title);
    }

    /** @test */
    public function itHasManyVariants()
    {
        /**
         * @var ShopProduct
         */
        $product = $this->createProduct();

        $this->createVariant($product);
        $this->createVariant($product);
        $this->createVariant($product);

        $this->assertEquals(3, $product->variants()->count());
    }

    /** @test */
    public function itHasAnImage()
    {
        /** @var ShopProduct $product */
        $product = $this->createProduct();

        $product->associateImage($this->makeImage());

        $this->assertEquals(1, $product->images()->count());
    }
}
