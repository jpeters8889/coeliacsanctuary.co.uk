<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Competition;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Spatie\TestTime\TestTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Competition\Models\Competition;

class CompetitionModelTest extends TestCase
{
    use RefreshDatabase;
    use HasImages;

    /** @test */
    public function itCreatesAUuidWhenCreatingARow()
    {
        $competition = factory(Competition::class)->create();

        $this->assertNotNull($competition->uuid);
        $this->assertTrue(Str::isUuid($competition->uuid));
    }

    /** @test */
    public function itCanHaveImages()
    {
        $competition = factory(Competition::class)->create();

        $competition->associateImage($this->makeImage());

        $this->assertNotNull($competition->first_image);
    }

    /** @test */
    public function itKnowsIfItsActive()
    {
        $competition = factory(Competition::class)->create();

        $this->assertIsBool($competition->isActive());
    }

    /** @test */
    public function itBecomesActiveAWeekBeforeItIsDueToBegin()
    {
        TestTime::freeze();

        $competition = factory(Competition::class)->create([
            'start_at' => Carbon::tomorrow()->addWeek()->startOfDay(),
        ]);

        $this->assertFalse($competition->isActive());

        TestTime::addDay();

        $this->assertTrue($competition->isActive());
    }

    /** @test */
    public function itEndsBeingActive28DaysAfterTheCompetitionHasEnded()
    {
        TestTime::freeze();

        $competition = factory(Competition::class)->create([
            'end_At' => Carbon::now()->addWeek()->endOfDay(),
        ]);

        $this->assertTrue($competition->isActive());

        TestTime::addWeek()->addDay();

        $this->assertTrue($competition->isActive());

        TestTime::addDays(29);

        $this->assertFalse($competition->isActive());
    }

    /** @test */
    public function itKnowsWhenItsOpen()
    {
        TestTime::freeze();

        $competition = factory(Competition::class)->create([
            'start_at' => Carbon::tomorrow()->startOfDay(),
            'end_at' => Carbon::tomorrow()->endOfDay(),
        ]);

        $this->assertFalse($competition->isOpenForEntries());

        TestTime::addDay();

        $this->assertTrue($competition->isOpenForEntries());

        TestTime::addDay();

        $this->assertFalse($competition->isOpenForEntries());
    }
}
