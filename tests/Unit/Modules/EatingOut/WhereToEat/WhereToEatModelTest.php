<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Tests\Traits\ClearingCacheTest;
use Tests\Traits\CreatesWhereToEat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatModelTest extends TestCase
{
    use RefreshDatabase;
    use CreatesWhereToEat;
    use ClearingCacheTest;

    /** @var WhereToEat */
    private $wheretoeat;

    public function setUp(): void
    {
        parent::setUp();

        $this->wheretoeat = $this->createWhereToEat();
    }

    /** @test */
    public function itHasATown(): void
    {
        $this->assertEquals(1, $this->wheretoeat->town()->count());
    }

    /** @test */
    public function itHasACounty()
    {
        $this->assertEquals(1, $this->wheretoeat->county()->count());
    }

    /** @test */
    public function itHasACountry()
    {
        $this->assertEquals(1, $this->wheretoeat->country()->count());
    }

    /** @test */
    public function itHasFeatures()
    {
        $this->assertEquals(1, $this->wheretoeat->features()->count());
    }

    /** @test */
    public function itHasAVenueType()
    {
        $this->assertEquals(1, $this->wheretoeat->venueType()->count());
    }

    /** @test */
    public function itHasACuisineType()
    {
        $this->assertEquals(1, $this->wheretoeat->cuisine()->count());
    }

    protected function cacheKey(): string
    {
        return 'wheretoeat';
    }

    protected function makeCachedModel(): void
    {
        $this->createWhereToEat();
    }
}
