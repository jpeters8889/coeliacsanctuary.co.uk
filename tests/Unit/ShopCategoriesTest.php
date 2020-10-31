<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\CreateCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopCategoriesTest extends TestCase
{
    use RefreshDatabase;
    use CreateCategory;
    use CreateProduct;
    use CreateVariant;

    /** @test */
    public function it_has_products()
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
    public function it_has_many_products()
    {
        /**
         * @var ShopCategory
         */
        $category = $this->createCategory();

        /*
         * @var ShopProduct
         */
        $this->createProduct($category, ['title' => 'Product 1']);

        /*
         * @var ShopProduct
         */
        $this->createProduct($category, ['title' => 'Product 2']);

        $this->assertEquals(2, $category->products()->count());
    }

    /** @test */
    public function it_has_custom_where_clause_for_products()
    {
        /**
         * @var ShopCategory
         */
        $category = $this->createCategory();

        $this->assertEquals(0, ShopCategory::query()->where('id', $category->id)->withLiveProducts()->count());

        $product = $this->createProduct($category);

        $this->assertEquals(0, ShopCategory::query()->where('id', $category->id)->withLiveProducts()->count());

        /** @var ShopProductVariant */
        $variant = $this->createVariant($product, ['live' => false]);

        $this->assertEquals(0, ShopCategory::query()->where('id', $category->id)->withLiveProducts()->count());

        $variant->live = true;
        $variant->update();

        $variant->fresh();

        $this->assertEquals(1, ShopCategory::query()->where('id', $category->id)->withLiveProducts()->count());
    }
}
