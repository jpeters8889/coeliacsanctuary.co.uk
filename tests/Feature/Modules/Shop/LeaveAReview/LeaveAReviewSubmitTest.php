<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\LeaveAReview;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderReview;
use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Coeliac\Modules\Shop\Models\ShopOrderReviewItem;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Models\ShopSource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaveAReviewSubmitTest extends TestCase
{
    use WithFaker;

    protected User $user;
    protected ShopOrder $order;
    protected ShopOrderReviewInvitation $invitation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->asShipping(), 'addresses')
            ->create();

        $this->order = $this->build(ShopOrder::class)
            ->asCompleted()
            ->to($this->user)
            ->has($this->build(ShopPayment::class), 'payment')
            ->create();

        $this->build(ShopOrderItem::class)
            ->to($this->order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $this->invitation = $this->order->reviewInvitation()->create();
    }

    /** @test */
    public function itErrorsWhenPostingToAnInvitationThatDoesntExist(): void
    {
        $this->post('/api/shop/review-my-order/foo')->assertNotFound();
    }

    /** @test */
    public function itReturnsNotFoundWhenAReviewIsLinkedToTheInvitation(): void
    {
        $this->assertNotEquals(404, $this->post("/api/shop/review-my-order/{$this->invitation->id}")->status());

        $this->invitation->review()->create(['order_id' => $this->order->id, 'name' => $this->faker->name]);

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ])->assertNotFound();
    }

    /** @test */
    public function itAllowsRequestsWithoutAName(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => []])
            ->assertJsonMissingValidationErrors('name');
    }

    /** @test */
    public function itErrorsIfARequestHasAnInvalidName(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['name' => 123])
            ->assertJsonValidationErrorFor('name');
    }

    /** @test */
    public function itAllowsRequestsWithoutWhereHeard(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => []])
            ->assertJsonMissingValidationErrors('whereHeard');
    }

    /** @test */
    public function itErrorsWhenWhereHeardIsntAnArray(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['whereHeard' => 123])
            ->assertJsonValidationErrorFor('whereHeard');
    }

    /** @test */
    public function itErrorsWhenWhereHeardIsntAnArrayOfStrings(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['whereHeard' => ['foo', 123]])
            ->assertJsonMissingValidationErrors('whereHeard')
            ->assertJsonMissingValidationErrors('whereHeard.0')
            ->assertJsonValidationErrorFor('whereHeard.1');
    }

    /** @test */
    public function itErrorsWithoutAProductsParameterInTheRequest(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}")
            ->assertJsonValidationErrorFor('products');
    }

    /** @test */
    public function itErrorsIfTheProductsParameterIsntAnArray(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => 'foo'])
            ->assertJsonValidationErrorFor('products');
    }

    /** @test */
    public function itErrorsIfAProductDoesntHaveAnId(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['feedback' => 'foo']]])
            ->assertJsonValidationErrorFor('products.0.id');
    }

    /** @test */
    public function itErrorsIfAProductDoesntHasAnInvalidId(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['id' => 'foo']]])
            ->assertJsonValidationErrorFor('products.0.id');
    }

    /** @test */
    public function itErrorsIfAProductHasAIdThatDoesntExist(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['id' => 999]]])
            ->assertJsonValidationErrorFor('products.0.id');
    }

    /** @test */
    public function itErrorsIfTryingToLeaveFeedbackForAnItemNotInTheOrder(): void
    {
        $product = $this->create(ShopProduct::class);

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['id' => $product->id]]])
            ->assertJsonValidationErrorFor('products.0.id');
    }

    /** @test */
    public function itErrorsIfAProductDoesntHaveARating(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['id' => 1]]])
            ->assertJsonValidationErrorFor('products.0.rating');
    }

    /** @test */
    public function itErrorsIfAProductHasARatingThatIsntNumeric(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['rating' => 'foo']]])
            ->assertJsonValidationErrorFor('products.0.rating');
    }

    /** @test */
    public function itErrorsIfAProductsHasARatingThatIsntInTheRange(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['rating' => -1]]])
            ->assertJsonValidationErrorFor('products.0.rating');

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['rating' => 6]]])
            ->assertJsonValidationErrorFor('products.0.rating');
    }

    /** @test */
    public function itDoesntErrorIfAProductDoesntHaveAReview(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['rating' => 5]]])
            ->assertJsonMissingValidationErrors('products.0.name');
    }

    /** @test */
    public function itErrorsIfAProductHasAnInvalidReview(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", ['products' => [['review' => 123]]])
            ->assertJsonValidationErrorFor('products.0.review');
    }

    /** @test */
    public function itReturnsOk(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ])->assertOk();
    }

    /** @test */
    public function itCreatesAReview(): void
    {
        $this->assertEmpty(ShopOrderReview::all());
        $this->assertEmpty($this->order->reviews);
        $this->assertEmpty($this->invitation->review);

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertNotEmpty(ShopOrderReview::all());
        $this->assertCount(1, ShopOrderReview::all());

        $this->assertNotEmpty($this->order->fresh()->reviews);
        $this->assertNotEmpty($this->invitation->fresh()->review);
    }

    /** @test */
    public function itStoresTheNameWithTheReview(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => 'Foo Bar',
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertEquals('Foo Bar', $this->invitation->review->name);
    }

    /** @test */
    public function itStoresTheItemReviews(): void
    {
        $product = ShopProduct::query()->first();

        $this->assertEmpty(ShopOrderReviewItem::all());
        $this->assertEmpty($this->order->reviewedItems);
        $this->assertEmpty($product->reviews);

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertNotEmpty(ShopOrderReviewItem::all());
        $this->assertCount(1, ShopOrderReviewItem::all());

        $this->assertNotEmpty($this->order->fresh()->reviewedItems);
        $this->assertNotEmpty($product->fresh()->reviews);
    }

    /** @test */
    public function itStoresTheCorrectValues(): void
    {
        $review = [
            'id' => 1,
            'rating' => 5,
            'review' => $this->faker->paragraph,
        ];
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [$review],
        ]);

        $review = ShopOrderReviewItem::query()->first();

        $this->assertEquals($review['id'], $review->product_id);
        $this->assertEquals($review['rating'], $review->rating);
        $this->assertEquals($review['review'], $review->review);
    }

    /** @test */
    public function itCanCreateMultpleReviewsAtOnce(): void
    {
        $this->build(ShopOrderItem::class)
            ->to($this->order)
            ->add($this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->create())
            ->create(['weight' => 10]))
            ->create();

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
                [
                    'id' => 2,
                    'rating' => 4,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertCount(2, $this->order->reviewedItems);
        $this->assertCount(2, ShopOrderReviewItem::all());
    }

    /** @test */
    public function itCreatesANewOrderSource(): void
    {
        $this->assertEmpty(ShopSource::all());
        $this->assertEmpty($this->order->sources);

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertNotEmpty(ShopSource::all());
        $this->assertCount(1, ShopSource::all());

        $this->assertNotEmpty($this->order->fresh()->sources);
        $this->assertCount(1, $this->order->fresh()->sources);
    }

    /** @test */
    public function itCreatesTheCorrectOrderSource(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertEquals('Facebook', ShopSource::query()->first()->source);
    }

    /** @test */
    public function itAssociatesTheSourceWithTheOrder(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertEquals('Facebook', $this->order->sources()->first()->source);
    }

    /** @test */
    public function itMatchesOntoExistingSources(): void
    {
        ShopSource::query()->create(['source' => 'Facebook']);

        $this->assertCount(1, ShopSource::all());
        $this->assertEmpty($this->order->sources);

        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ]);

        $this->assertCount(1, ShopSource::all());
        $this->assertNotEmpty($this->order->fresh()->sources);
    }

    /** @test */
    public function itReturnsADoneMessage(): void
    {
        $this->post("/api/shop/review-my-order/{$this->invitation->id}", [
            'name' => $this->faker->name,
            'whereHeard' => ['Facebook', 'Instagram'],
            'products' => [
                [
                    'id' => 1,
                    'rating' => 5,
                    'review' => $this->faker->paragraph,
                ],
            ],
        ])->assertJsonFragment(['data' => 'done']);
    }
}
