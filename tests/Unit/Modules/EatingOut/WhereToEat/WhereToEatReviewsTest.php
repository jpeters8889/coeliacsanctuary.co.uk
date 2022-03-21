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
    public function itHasAnAverageExpenseAttribute()
    {
        $this->whereToEat->userReviews()->delete();

        $this->build(WhereToEatReview::class)
            ->on($this->whereToEat)
            ->count(2)
            ->state(new Sequence(
                ['how_expensive' => 1],
                ['how_expensive' => 5],
            ))
            ->create();

        $averageExpense = $this->whereToEat->fresh()->with('userReviews')->first()->average_expense;

        $this->assertIsArray($averageExpense);
        $this->assertArrayHasKey('value', $averageExpense);
        $this->assertArrayHasKey('label', $averageExpense);
        $this->assertEquals(3, $averageExpense['value']);

    }

    /** @test */
    public function itRoundsTheAveragePriceRatingToTheNearestWholeNumber()
    {
        $this->whereToEat->userReviews()->delete();

        $this->build(WhereToEatReview::class)
            ->on($this->whereToEat)
            ->count(3)
            ->state(new Sequence(
                ['how_expensive' => 4],
                ['how_expensive' => 5],
                ['how_expensive' => 5],
            ))
            ->create();

        $this->assertEquals(5, $this->whereToEat->fresh()->with('userReviews')->first()->average_expense['value']);
    }
}
