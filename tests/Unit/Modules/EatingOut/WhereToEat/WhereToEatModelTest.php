<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Tests\TestCase;
use Tests\Traits\ClearsCache;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatModelTest extends TestCase
{
    use ClearsCache;

    /** @var WhereToEat */
    private WhereToEat $wheretoeat;

    public function setUp(): void
    {
        parent::setUp();

        $this->wheretoeat = $this->build(WhereToEat::class)
            ->has($this->build(WhereToEatFeature::class), 'features')
            ->create();
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
        $this->create(WhereToEat::class);
    }
}
