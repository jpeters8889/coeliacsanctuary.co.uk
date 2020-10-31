<?php

declare(strict_types=1);

namespace Tests\Architect;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Architect\Plans\ShopProductPrices\Plan;
use JPeters\Architect\TestHelpers\Abstracts\PlanTestCase;

class ShopPricesPlanTest extends PlanTestCase
{
    public function getPlan()
    {
        return Plan::class;
    }

    public function getColumnName()
    {
        return 'prices';
    }

    public function it_updates_the_model()
    {
        /** @var ShopCategory $category */
        $category = ShopCategory::query()->create();

        /** @var ShopProduct $product */
        $product = $category->products()->create();

        $product->prices()->create(['price' => 500]);
        $product->prices()->create(['price' => 600]);

        $currentPrices = $product->prices();

        $class = $this->getPlan();

        $prices = [
            [
                'price' => 2000,
                'sale_price' => false,
                'start_at' => '2020-04-25',
                'end_at' => null,
            ],
            [
                'price' => 1000,
                'sale_price' => true,
                'start_at' => '2020-05-01',
                'end_at' => '2020-05-04',
            ],
        ];

        /** @var Plan $plan */
        $plan = new $class('price');

        $plan->handleUpdate($product, 'price', json_encode($prices));

        $currentPrices->each(fn (ShopProductPrice $price) => $this->assertDeleted($price));

        $this->assertCount(2, $product->fresh()->prices);

        foreach ($prices as $index => $price) {
            /** @var ShopProductPrice $product */
            $product = $product->prices[$index];

            $this->assertEquals($price['price'], $product->price);
            $this->assertEquals(Carbon::parse($price['start_at']), $product->start_at);

            $saleMethod = 'assertTrue';
            if ($index === 1) {
                $saleMethod = 'assertFalse';
            }

            $this->$saleMethod($product->sale_price);

            if ($index === 0) {
                $this->assertNull($product->end_at);
            }

            if ($index === 1) {
                $this->assertEquals(Carbon::parse($price['end_at']), $product->end_at);
            }
        }
    }
}
