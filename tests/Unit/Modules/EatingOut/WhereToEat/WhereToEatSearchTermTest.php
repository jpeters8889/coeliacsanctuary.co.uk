<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;
use Tests\TestCase;

class WhereToEatSearchTermTest extends TestCase
{
    /** @test */
    public function itGeneratesAKeyWhenARowIsCreated()
    {
        $this->assertNotNull($this->create(WhereToEatSearchTerm::class)->key);
    }

    /** @test */
    public function itCanHaveSearchesAppliedToIt()
    {
        /** @var WhereToEatSearchTerm $searchTerm */
        $searchTerm = $this->create(WhereToEatSearchTerm::class);

        $this->assertEmpty($searchTerm->searches);

        $searchTerm->logSearch();

        $this->assertNotEmpty($searchTerm->fresh()->searches);
        $this->assertCount(1, $searchTerm->fresh()->searches);

        $searchTerm->logSearch();

        $this->assertCount(2, $searchTerm->fresh()->searches);
    }
}
