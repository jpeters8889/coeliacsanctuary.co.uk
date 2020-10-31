<?php

declare(strict_types=1);

namespace Tests\Unit;

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
    public function it_has_a_town()
    {
        $this->assertEquals(1, $this->wheretoeat->town()->count());
    }

    /** @test */
    public function it_has_a_county()
    {
        $this->assertEquals(1, $this->wheretoeat->county()->count());
    }

    /** @test */
    public function it_has_a_country()
    {
        $this->assertEquals(1, $this->wheretoeat->country()->count());
    }

    /** @test */
    public function it_has_features()
    {
        $this->assertEquals(1, $this->wheretoeat->features()->count());
    }

    /** @test */
    public function it_has_a_venue_type()
    {
        $this->assertEquals(1, $this->wheretoeat->venueType()->count());
    }

    /** @test */
    public function it_has_a_cuisine_type()
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
