<?php

declare(strict_types=1);

namespace Tests\Architect;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Architect\Plans\ShopProductVariants\Plan;
use JPeters\Architect\TestHelpers\Abstracts\PlanTestCase;

class ShopVariantsPlanTest extends PlanTestCase
{
    public function getPlan()
    {
        return Plan::class;
    }

    public function getColumnName()
    {
        return 'variants';
    }

    public function itUpdatesTheModel()
    {
        /** @var ShopCategory $category */
        $category = ShopCategory::query()->create();

        /** @var ShopProduct $product */
        $product = $category->products()->create();

        $variant = $product->variants()->create([
            'title' => 'Foo',
            'weight' => 100,
            'quantity' => 123,
        ]);

        $class = $this->getPlan();

        $variants = [
            'update' => [
                [
                    'id' => $variant->id,
                    'title' => 'Foobar',
                    'weight' => 200,
                    'quantity' => 456,
                ],
            ],
            'add' => [
                [
                  'title' => 'new',
                  'weight' => 1,
                  'quantity' => 2,
                ],
                [
                    'title' => 'Second new',
                    'weight' => 10,
                    'quantity' => 20,
                ],
            ],
        ];

        $plan = new $class('variant');

        $plan->handleUpdate($product, 'variant', json_encode($variants));

        $this->assertCount(3, $product->fresh()->variants);

        $this->assertEquals('Foobar', $variant->fresh()->title);
        $this->assertEquals(200, $variant->fresh()->weight);
        $this->assertEquals(456, $variant->fresh()->quantity);

        $variantChecks = $product->fresh()->variants()->where('id', $variant->id)->get();
        foreach ($variants['add'] as $index => $variant) {
            $this->assertEquals($variant['title'], $variantChecks[$index]['title']);
            $this->assertEquals($variant['weight'], $variantChecks[$index]['weight']);
            $this->assertEquals($variant['quantity'], $variantChecks[$index]['quantity']);
        }
    }
}
