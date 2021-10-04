<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Discounts;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopMassDiscount;
use Coeliac\Modules\Shop\Models\ShopProductPrice;

class ShopMassDiscountsTest extends TestCase
{
    private ShopProduct $firstProduct;
    private ShopProduct $secondProduct;

    protected function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();

        [$this->firstProduct, $this->secondProduct] = $this->build(ShopProduct::class)
            ->count(2)
            ->state(new Sequence(
                ['title' => 'First Product'],
                ['title' => 'Second Product'],
            ))
            ->has($this->build(ShopProductPrice::class), 'prices')
            ->has($this->build(ShopProductVariant::class), 'variants')
            ->create();

        $this->create(ShopCategory::class)
            ->products()
            ->attach($this->firstProduct);

        $this->create(ShopCategory::class)
            ->products()
            ->attach($this->secondProduct);
    }

    /** @test */
    public function itCanHaveCategories()
    {
        /** @var ShopMassDiscount $discount */
        $discount = $this->create(ShopMassDiscount::class);

        $this->assertEmpty($discount->assignedCategories);

        $discount->assignedCategories()->attach($this->create(ShopCategory::class));

        $this->assertCount(1, $discount->fresh()->assignedCategories);
    }

    /** @test */
    public function itAppliesTheDiscountToAllProducts()
    {
        /** @var ShopMassDiscount $discount */
        $discount = $this->create(ShopMassDiscount::class);
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
        $notLiveProduct = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class), 'prices')
            ->has($this->build(ShopProductVariant::class)->notLive(), 'variants')
            ->create();

        /** @var ShopMassDiscount $discount */
        $discount = $this->create(ShopMassDiscount::class);
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
        $discount = $this->create(ShopMassDiscount::class);
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
        $discount = $this->create(ShopMassDiscount::class, ['percentage' => 10]);

        $discount->assignedCategories()->attach([1, 2]);

        $prices = [$this->firstProduct->currentPrice, $this->secondProduct->currentPrice];

        TestTime::addMinute();
        $this->artisan('coeliac:apply_mass_discounts');

        foreach ([$this->firstProduct->fresh(), $this->secondProduct->fresh()] as $index => $product) {
            $this->assertGreaterThan(1, $product->prices->count());

            /** @var ShopProduct $product */
            /** @var ShopProductPrice $latestPrice */
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
        $discount = $this->create(ShopMassDiscount::class, ['percentage' => 10]);
        $discount->assignedCategories()->attach(1);

        $this->firstProduct->prices->first()->update(['price' => 100]);

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
        $discount = $this->create(ShopMassDiscount::class, ['percentage' => 10, 'end_at' => Carbon::today()]);

        $this->firstProduct->prices->first()->update(['price' => 100]);

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
