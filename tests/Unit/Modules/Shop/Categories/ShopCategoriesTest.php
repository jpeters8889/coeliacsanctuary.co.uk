<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Shop\Categories;

use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\TestCase;

class ShopCategoriesTest extends TestCase
{
    /** @test */
    public function itHasProducts()
    {
        $category = $this->create(ShopCategory::class);
        $product = $this->create(ShopProduct::class);
        $category->products()->attach($product);

        $this->assertEquals(1, $category->products()->count());
        $this->assertEquals($product->title, $category->products()->first()->title);
    }

    /** @test */
    public function itHasManyProducts()
    {
        $category = $this->create(ShopCategory::class);

        $this->build(ShopProduct::class)->count(2)->create();

        ShopProduct::query()->get()->each(fn (ShopProduct $product) => $product->categories()->attach($category));

        $this->assertEquals(2, $category->products()->count());
    }

    /** @test */
    public function itHasCustomWhereClauseForProducts()
    {
        $category = $this->create(ShopCategory::class);

        $this->assertEquals(0, ShopCategory::withLiveProducts()->where('id', $category->id)->count());

        $product = $this->create(ShopProduct::class);
        $category->products()->attach($product);

        $this->assertEquals(0, ShopCategory::withLiveProducts()->where('id', $category->id)->count());

        /** @var ShopProductVariant */
        $variant = $this->build(ShopProductVariant::class)
            ->in($product)
            ->create(['live' => false]);

        $this->assertEquals(0, ShopCategory::withLiveProducts()->where('id', $category->id)->count());

        $variant->live = true;
        $variant->update();

        $variant->fresh();

        $this->assertEquals(1, ShopCategory::withLiveProducts()->where('id', $category->id)->count());
    }
}
