<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Competition;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Competition\Models\CompetitionEntry;

class CompetitionEntryModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itCreatesAUuidWhenCreatingARow()
    {
        $competition = CompetitionEntry::query()->create([
            'competition_id' => 1,
            'name' => 'foo',
            'email' => 'bar',
            'entry_type' => 'baz',
        ]);

        $this->assertNotNull($competition->id);
        $this->assertTrue(Str::isUuid($competition->id));
    }
}
