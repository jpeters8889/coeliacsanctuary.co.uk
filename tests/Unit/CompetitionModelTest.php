<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Coeliac\Common\Models\Image;
use Illuminate\Support\Str;
use Spatie\TestTime\TestTime;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Competition\Models\Competition;
use Tests\Traits\HasImages;

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
    public function it_can_have_images()
    {
        $competition = factory(Competition::class)->create();

        $competition->associateImage($this->makeImage());

        $this->assertNotNull($competition->first_image);
    }

    /** @test */
    public function it_knows_if_its_active()
    {
        $competition = factory(Competition::class)->create();

        $this->assertIsBool($competition->isActive());
    }

    /** @test */
    public function it_becomes_active_a_week_before_it_is_due_to_begin()
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
    public function it_ends_being_active_28_days_after_the_competition_has_ended()
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
    public function it_knows_when_its_open()
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
