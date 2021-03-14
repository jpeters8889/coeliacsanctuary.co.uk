<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Spatie\TestTime\TestTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Competition\Models\Competition;

class CompetitionTest extends TestCase
{
    use HasImages;
    use RefreshDatabase;

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

        $competition = factory(Competition::class)->create([
            'start_at' => Carbon::tomorrow()->addWeek()->startOfDay(),
            'end_at' => Carbon::tomorrow()->addWeek()->endOfDay(),
        ]);

        $this->get('/competition/'.$competition->slug)->assertNotFound();

        TestTime::addWeeks(6);

        $this->get('/competition/'.$competition->slug)->assertNotFound();
    }

    /** @test */
    public function itReturnsOkWhenLoadingACompetitionThatIsActive()
    {
        TestTime::freeze();

        $competition = factory(Competition::class)->create([
            'start_at' => Carbon::yesterday()->startOfDay(),
            'end_at' => Carbon::yesterday()->addWeek()->endOfDay(),
        ]);

        $competition->associateImage($this->makeImage());

        $this->get('/competition/'.$competition->slug)->assertOk();
    }

    /** @test */
    public function itCanReturnTheTerms()
    {
        $this->withoutExceptionHandling();

        $competition = factory(Competition::class)->create();

        $request = $this->get("/api/competition/{$competition->uuid}/terms");

        $request->assertOk();

        $this->assertEquals($competition->terms, $request->content());
    }
}
