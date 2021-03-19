<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;

class WhereToEatSearchTermTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itGeneratesAKeyWhenARowIsCreated()
    {
        $searchTerm = factory(WhereToEatSearchTerm::class)->create();

        $this->assertNotNull($searchTerm->key);
    }

    /** @test */
    public function itCanHaveSearchesAppliedToIt()
    {
        /** @var WhereToEatSearchTerm $searchTerm */
        $searchTerm = factory(WhereToEatSearchTerm::class)->create();

        $this->assertEmpty($searchTerm->searches);

        $searchTerm->logSearch();

        $this->assertNotEmpty($searchTerm->fresh()->searches);
        $this->assertCount(1, $searchTerm->fresh()->searches);

        $searchTerm->logSearch();

        $this->assertCount(2, $searchTerm->fresh()->searches);
    }
}
