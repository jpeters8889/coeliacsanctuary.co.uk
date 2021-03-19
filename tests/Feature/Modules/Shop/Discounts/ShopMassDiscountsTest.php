<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Discounts;

use Carbon\Carbon;
use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\CreateCategory;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopMassDiscount;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopMassDiscountsTest extends TestCase
{
    use CreateProduct;
    use CreateCategory;
    use CreateVariant;
    use RefreshDatabase;

    private ShopProduct $firstProduct;
    private ShopProduct $secondProduct;

    protected function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();

        $firstCategory = $this->createCategory(['title' => 'First Category']);
        $secondCategory = $this->createCategory(['title' => 'Second Category']);

        $this->firstProduct = $this->createProduct($firstCategory, ['title' => 'First Product']);
        $this->secondProduct = $this->createProduct($secondCategory, ['title' => 'Second Product']);

        $this->createVariant($this->firstProduct, ['live' => true]);
        $this->createVariant($this->secondProduct, ['live' => true]);

        factory(ShopProductPrice::class)->create([
            'product_id' => 1,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        factory(ShopProductPrice::class)->create([
            'product_id' => 2,
            'price' => 200,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);
    }

    /** @test */
    public function itCanHaveCategories()
    {
        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create();

        $this->assertEmpty($discount->assignedCategories);

        $discount->assignedCategories()->attach(1);

        $this->assertCount(1, $discount->fresh()->assignedCategories);
    }

    /** @test */
    public function itAppliesTheDiscountToAllProducts()
    {
        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create();
        $discount->assignedCategories()->attach([1, 2]);

        $this->assertCount(1, $this->firstProduct->prices);
        $this->assertCount(1, $this->secondProduct->prices);

        TestTime::addMinute();

        $this->artisan('coeliac:apply_mass_discounts');

        $this->assertCount(2, $this->firstProduct->fresh()->prices);
        $this->assertCount(2, $this->secondProduct->fresh()->prices);
    }

    /** @test */
    public function itDoesntApplyTheDiscountsToNotLiveProducts()
    {
        $notLiveProduct = $this->createProduct(ShopCategory::query()->first(), ['title' => 'First Product']);
        $this->createVariant($notLiveProduct, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $notLiveProduct->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create();
        $discount->assignedCategories()->attach(1);

        $this->assertCount(1, $notLiveProduct->prices);

        TestTime::addMinute();

        $this->artisan('coeliac:apply_mass_discounts');

        $this->assertCount(1, $notLiveProduct->prices);
    }

    /** @test */
    public function itDoesntApplyTheDiscountToCategoriesNotInTheDiscount()
    {
        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create();
        $discount->assignedCategories()->attach(2);

        $this->assertCount(1, $this->firstProduct->prices);

        TestTime::addMinute();

        $this->artisan('coeliac:apply_mass_discounts');

        $this->assertCount(1, $this->firstProduct->fresh()->prices);
    }

    /** @test */
    public function itAppliesTheCorrectDiscounts()
    {
        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create(['percentage' => 10]);
        $discount->assignedCategories()->attach([1, 2]);

        $prices = [$this->firstProduct->currentPrice, $this->secondProduct->currentPrice];

        TestTime::addMinute();
        $this->artisan('coeliac:apply_mass_discounts');

        foreach ([$this->firstProduct->fresh(), $this->secondProduct->fresh()] as $index => $product) {
            /** @var ShopProduct $product */
            $latestPrice = $product->prices()->latest()->first();

            $this->assertTrue($discount->start_at->eq($latestPrice->start_at));
            $this->assertTrue($discount->end_at->eq($latestPrice->end_at));
            $this->assertTrue((bool) $latestPrice->sale_price);
            $this->assertEquals($newPrice = $prices[$index] * 0.9, $latestPrice->price); // discount is set as 10%

            $this->assertEquals($newPrice, $product->currentPrice);
            $this->assertIsArray($product->price);
        }
    }

    /** @test */
    public function itShowsTheNewPriceOnThePage()
    {
        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create(['percentage' => 10]);
        $discount->assignedCategories()->attach(1);

        $this->get('/api/shop/product/'.$this->firstProduct->id)
            ->assertJsonStructure(['data' => ['price' => ['current_price']]])
            ->assertJsonMissing(['old_price'])
            ->assertJsonFragment(['current_price' => '100']);

        TestTime::addMinute();

        $this->artisan('coeliac:apply_mass_discounts');

        $this->get('/api/shop/product/'.$this->firstProduct->id)
            ->assertJsonStructure(['data' => ['price' => ['current_price', 'old_price']]])
            ->assertJsonFragment(['current_price' => '90'])
            ->assertJsonFragment(['old_price' => '100']);
    }

    /** @test */
    public function itDoesntReturnAfterTheEndDateHasAssed()
    {
        /** @var ShopMassDiscount $discount */
        $discount = factory(ShopMassDiscount::class)->create(['percentage' => 10, 'end_at' => Carbon::today()]);
        $discount->assignedCategories()->attach(1);

        TestTime::addMinute();

        $this->artisan('coeliac:apply_mass_discounts');

        $this->get('/api/shop/product/'.$this->firstProduct->id)
            ->assertJsonFragment(['current_price' => '90']);

        TestTime::addDay()->startOfDay();

        $this->get('/api/shop/product/'.$this->firstProduct->id)
            ->assertJsonFragment(['current_price' => '100']);
    }
}
