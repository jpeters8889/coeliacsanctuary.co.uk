<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;

class WhereToEatSearchTermTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_a_key_when_a_row_is_created()
    {
        $searchTerm = factory(WhereToEatSearchTerm::class)->create();

        $this->assertNotNull($searchTerm->key);
    }

    /** @test */
    public function it_can_have_searches_applied_to_it()
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
