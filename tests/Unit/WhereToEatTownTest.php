<?php

namespace Tests\Unit;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class WhereToEatTownTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        factory(WhereToEatCountry::class)->create();
        factory(WhereToEatCounty::class)->create(['country_id' => 1]);
    }

    /** @test */
    public function it_creates_a_slug_when_a_town_is_created()
    {
        WhereToEatTown::query()->create([
            'county_id' => 1,
            'town' => $townName = 'Foo Bar',
        ]);

        /** @var WhereToEatTown $town */
        $town = WhereToEatTown::query()->first();

        $this->assertNotNull($town->slug);
        $this->assertEquals(Str::slug($townName), $town->slug);
    }
}
