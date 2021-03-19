<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

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
    public function itCreatesASlugWhenATownIsCreated()
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
