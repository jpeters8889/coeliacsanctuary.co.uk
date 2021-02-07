<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Tests\Traits\CreatesWhereToEat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;

class WhereToEatRatingsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesWhereToEat;

    /** @var WhereToEat */
    protected $whereToEat;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->whereToEat = $this->createWhereToEat();
    }

    /** @test */
    public function itHasRatings()
    {
        factory(WhereToEatRating::class)->create(['wheretoeat_id' => $this->whereToEat->id]);

        $this->assertEquals(1, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault()
    {
        factory(WhereToEatRating::class)->create(['wheretoeat_id' => $this->whereToEat->id]);

        $this->assertFalse($this->whereToEat->fresh()->ratings()->first()->approved);
    }

    /** @test */
    public function itHasAnAverageRating()
    {
        factory(WhereToEatRating::class)->create(
            [
                'wheretoeat_id' => $this->whereToEat->id,
                'rating' => 5,
                'approved' => true,
            ]
        );
        factory(WhereToEatRating::class)->create(
            [
                'wheretoeat_id' => $this->whereToEat->id,
                'rating' => 4,
                'approved' => true,
            ]
        );

        $this->assertEquals(4.5, $this->whereToEat->fresh()->with('ratings')->first()->average_rating);
    }
}