<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatOpeningTimes;
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
    public function itHasACounty(): void
    {
        $this->assertEquals(1, $this->wheretoeat->county()->count());
    }

    /** @test */
    public function itHasACountry(): void
    {
        $this->assertEquals(1, $this->wheretoeat->country()->count());
    }

    /** @test */
    public function itHasFeatures(): void
    {
        $this->assertEquals(1, $this->wheretoeat->features()->count());
    }

    /** @test */
    public function itHasAVenueType(): void
    {
        $this->assertEquals(1, $this->wheretoeat->venueType()->count());
    }

    /** @test */
    public function itHasACuisineType(): void
    {
        $this->assertEquals(1, $this->wheretoeat->cuisine()->count());
    }

    /** @test */
    public function itCanHaveOpeningTimes(): void
    {
        $this->assertNull($this->wheretoeat->openingTimes);

        $openingTimes = $this->build(WhereToEatOpeningTimes::class)
            ->forEatery($this->wheretoeat)
            ->create();

        $this->assertNotNull($this->wheretoeat->refresh()->openingTimes);
        $this->assertTrue($this->wheretoeat->openingTimes->is($openingTimes));
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
