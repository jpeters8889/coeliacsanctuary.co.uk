<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;

class WhereToEatRatingsTest extends TestCase
{
    protected WhereToEat $whereToEat;

    protected function setUp(): void
    {
        parent::setUp();

        $this->whereToEat = $this->create(WhereToEat::class);

        $this->build(WhereToEatRating::class)
            ->on($this->whereToEat)
            ->create();
    }

    /** @test */
    public function itHasRatings()
    {
        $this->assertEquals(1, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault()
    {
        $this->assertFalse($this->whereToEat->fresh()->ratings()->first()->approved);
    }

    /** @test */
    public function itHasAnAverageRating()
    {
        $this->whereToEat->ratings()->delete();

        $this->build(WhereToEatRating::class)
            ->on($this->whereToEat)
            ->count(2)
            ->state(new Sequence(
                ['rating' => 5],
                ['rating' => 4],
            ))
            ->create();

        $this->assertEquals(4.5, $this->whereToEat->fresh()->with('ratings')->first()->average_rating);
    }
}
