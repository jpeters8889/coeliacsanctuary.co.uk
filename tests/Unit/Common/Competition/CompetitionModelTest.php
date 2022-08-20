<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Competition;

use Coeliac\Modules\Competition\Models\Competition;
use Illuminate\Support\Str;
use Spatie\TestTime\TestTime;
use Tests\TestCase;
use Tests\Traits\HasImages;

class CompetitionModelTest extends TestCase
{
    use HasImages;

    /** @test */
    public function itCreatesAUuidWhenCreatingARow()
    {
        $competition = $this->create(Competition::class);

        $this->assertNotNull($competition->uuid);
        $this->assertTrue(Str::isUuid($competition->uuid));
    }

    /** @test */
    public function itCanHaveImages()
    {
        $competition = $this->create(Competition::class);

        $competition->associateImage($this->makeImage());

        $this->assertNotNull($competition->first_image);
    }

    /** @test */
    public function itKnowsIfItsActive()
    {
        $this->assertIsBool($this->create(Competition::class)->isActive());
    }

    /** @test */
    public function itBecomesActiveAWeekBeforeItIsDueToBegin()
    {
        TestTime::freeze();

        $competition = $this->build(Competition::class)
            ->that()
            ->startsNextWeek()
            ->create();

        $this->assertFalse($competition->isActive());

        TestTime::addDay();

        $this->assertTrue($competition->isActive());
    }

    /** @test */
    public function itEndsBeingActive28DaysAfterTheCompetitionHasEnded()
    {
        TestTime::freeze();

        $competition = $this->build(Competition::class)
            ->that()
            ->endsNextWeek()
            ->create();

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

        $competition = $this->build(Competition::class)
            ->that()
            ->isForOneDayOnly()
            ->create();

        $this->assertFalse($competition->isOpenForEntries());

        TestTime::addDay();

        $this->assertTrue($competition->isOpenForEntries());

        TestTime::addDay();

        $this->assertFalse($competition->isOpenForEntries());
    }
}
