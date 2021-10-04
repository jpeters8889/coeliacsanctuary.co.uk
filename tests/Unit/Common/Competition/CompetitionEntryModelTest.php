<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Competition;

use Tests\TestCase;
use Illuminate\Support\Str;
use Coeliac\Modules\Competition\Models\CompetitionEntry;

class CompetitionEntryModelTest extends TestCase
{
    /** @test */
    public function itCreatesAUuidWhenCreatingACompetitionEntry()
    {
        /** @var CompetitionEntry $competition */
        $entry = $this->create(CompetitionEntry::class);

        $this->assertNotNull($entry->id);
        $this->assertTrue(Str::isUuid($entry->id));
    }
}
