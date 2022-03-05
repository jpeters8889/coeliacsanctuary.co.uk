<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;

class WhereToEatReviewsTest extends TestCase
{
    protected WhereToEat $whereToEat;

    protected function setUp(): void
    {
        parent::setUp();

        $this->whereToEat = $this->create(WhereToEat::class);

        $this->build(WhereToEatReview::class)
            ->on($this->whereToEat)
            ->create();
    }

    /** @test */
    public function itHasReviews()
    {
        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault()
    {
        $this->assertFalse($this->whereToEat->fresh()->userReviews()->first()->approved);
    }

    /** @test */
    public function itHasAnAverageRating()
    {
        $this->whereToEat->userReviews()->delete();

        $this->build(WhereToEatReview::class)
            ->on($this->whereToEat)
            ->count(2)
            ->state(new Sequence(
                ['rating' => 5],
                ['rating' => 4],
            ))
            ->create();


        $this->assertEquals(4.5, $this->whereToEat->fresh()->with('userReviews')->first()->average_rating);
    }

    /** @test */
    public function itHasAnAveragePriceRange()
    {
        $this->whereToEat->userReviews()->delete();

        $this->build(WhereToEatReview::class)
            ->on($this->whereToEat)
            ->count(2)
            ->state(new Sequence(
                ['price_range' => 1],
                ['price_range' => 5],
            ))
            ->create();

        $priceRange = $this->whereToEat->fresh()->with('userReviews')->first()->average_price_range;

        $this->assertIsArray($priceRange);
        $this->assertArrayHasKey('value', $priceRange);
        $this->assertArrayHasKey('label', $priceRange);
        $this->assertEquals(3, $priceRange['value']);

    }

    /** @test */
    public function itRoundsTheAveragePriceRatingToTheNearestWholeNumber()
    {
        $this->whereToEat->userReviews()->delete();

        $this->build(WhereToEatReview::class)
            ->on($this->whereToEat)
            ->count(3)
            ->state(new Sequence(
                ['price_range' => 4],
                ['price_range' => 5],
                ['price_range' => 5],
            ))
            ->create();

        $this->assertEquals(5, $this->whereToEat->fresh()->with('userReviews')->first()->average_price_range['value']);
    }
}
