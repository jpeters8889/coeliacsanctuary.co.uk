<?php

namespace Tests\Feature\Modules\Shop\Products;

use Coeliac\Modules\Shop\Models\ShopOrderReview;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductReviewsTest extends TestCase
{
    use WithFaker;

    /** @var ShopProduct */
    private ShopProduct $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = $this->create(ShopProduct::class);

        $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->state(['quantity' => 15])
            ->create();

        /** @var ShopOrderReview $review */
        $review = ShopOrderReview::query()->create(['name' => $this->faker->name]);

        $review->products()->create([
            'product_id' => $this->product->id,
            'rating' => $this->faker->numberBetween(1, 5),
            'review' => $this->faker->paragraph,
        ]);
    }

    /** @test */
    public function itReturnsNotFoundIfTryingToGetReviewsForAProductThatDoesntExist(): void
    {
        $this->get('/api/shop/product/999/reviews')->assertNotFound();
    }

    /** @test */
    public function itReturnsOkForAValidProduct(): void
    {
        $this->get('/api/shop/product/1/reviews')->assertOk();
    }

    /** @test */
    public function itReturnsAPaginatedResponse(): void
    {
        $this->get('/api/shop/product/1/reviews')->assertJsonStructure(['data', 'current_page']);
    }

    /** @test */
    public function itReturnsAnArrayOfReviews(): void
    {
        $this->assertIsArray($this->get('/api/shop/product/1/reviews')->json('data'));
    }

    /** @test */
    public function itReturnsTheCorrectKeysWithEachReview(): void
    {
        $this->get('/api/shop/product/1/reviews')->assertJsonStructure([
            'data' => [
                ['id', 'name', 'rating', 'review', 'date'],
            ],
        ]);
    }
}
