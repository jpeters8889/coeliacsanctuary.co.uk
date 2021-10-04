<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Competitions;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Spatie\TestTime\TestTime;
use Coeliac\Modules\Competition\Models\Competition;

class CompetitionTest extends TestCase
{
    use HasImages;

    /** @test */
    public function itErrorsWhenAccessingTheRootCompetitionsUrl()
    {
        $this->get('/competition')->assertNotFound();
    }

    /** @test */
    public function itErrorsWhenLoadingACompetitionThatDoesntExist()
    {
        $this->get('/competition/foo')->assertNotFound();
    }

    /** @test */
    public function itErrorsWhenLoadingACompetitionThatIsntActive()
    {
        TestTime::freeze();

        $competition = $this->build(Competition::class)
            ->startsNextWeek()
            ->create();

        $this->get('/competition/'.$competition->slug)->assertNotFound();

        TestTime::addWeeks(6);

        $this->get('/competition/'.$competition->slug)->assertNotFound();
    }

    /** @test */
    public function itReturnsOkWhenLoadingACompetitionThatIsActive()
    {
        TestTime::freeze();

        $competition = $this->build(Competition::class)
            ->startedYesterday()
            ->create();

        $competition->associateImage($this->makeImage());

        $this->get('/competition/'.$competition->slug)->assertOk();
    }

    /** @test */
    public function itCanReturnTheTerms()
    {
        $competition = $this->create(Competition::class);

        $request = $this->get("/api/competition/{$competition->uuid}/terms");

        $request->assertOk();

        $this->assertEquals($competition->terms, $request->content());
    }
}
