<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Tests\TestCase;

class WhereToEatTest extends TestCase
{
    /** @var WhereToEat */
    private $wheretoeat;

    public function setUp(): void
    {
        parent::setUp();

        $this->wheretoeat = $this->build(WhereToEat::class)
            ->has($this->build(WhereToEatFeature::class), 'features')
            ->create();
    }

    /** @test */
    public function itLoadsTheCountyPage()
    {
        [$first, $second, $third] = $this->build(WhereToEat::class)
            ->count(3)
            ->create();

        $this->get('/wheretoeat/' . $this->wheretoeat->county->slug)
            ->assertSee($this->wheretoeat->town->town, false)
            ->assertSee($first->town->town, false)
            ->assertSee($second->town->town, false)
            ->assertSee($third->town->town, false);
    }

    /** @test */
    public function itLoadsTheSummaryEndpoint()
    {
        $this->get('/api/wheretoeat/summary')
            ->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'eateries',
                'attractions',
                'hotels',
                'reviews',
            ]);
    }

    /** @test */
    public function itLoadsTheVenueTypesEndpoint()
    {
        $this->get('/api/wheretoeat/venueTypes')->assertStatus(200);
    }
}
