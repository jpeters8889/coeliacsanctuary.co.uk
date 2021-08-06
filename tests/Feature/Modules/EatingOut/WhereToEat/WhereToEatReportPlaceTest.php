<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceReported as PlaceReportedMailable;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceReportSubmitted;
use Tests\Traits\CreatesWhereToEat;

class WhereToEatReportPlaceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use CreatesWhereToEat;

    protected WhereToEat $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eatery = $this->createWhereToEat();
        $this->setUpFaker();
    }

    /** @test */
    public function itErrorsWithoutAnyDetails()
    {
        $this->makeReportPlaceRequest(['details' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function itReturnsASuccesfulResponseWhenAllValidDataIsSent()
    {
        $this->withoutExceptionHandling();

        Event::fake();

        $this->makeReportPlaceRequest()->assertStatus(200);
    }

    /** @test */
    public function itStoresTheDataInTheDatabase()
    {
        Event::fake();

        $this->assertCount(0, $this->eatery->reports);

        $params = [
            'details' => $this->faker->paragraph,
        ];

        $this->makeReportPlaceRequest($params);

        $this->assertCount(1, $this->eatery->fresh()->reports);
    }

    /** @test */
    public function itEmitsAnEventWhenARequestIsReceived()
    {
        Event::fake();

        $this->makeReportPlaceRequest();

        Event::assertDispatched(PlaceReportSubmitted::class);
    }

    /** @test */
    public function itTriggersAnEmailWhenARequestIsRecieved()
    {
        Mail::fake();

        $this->makeReportPlaceRequest();

        Mail::assertSent(PlaceReportedMailable::class);
    }

    private function makeReportPlaceRequest($params = [])
    {
        return $this->post("/api/wheretoeat/{$this->eatery->id}/report", array_merge([
            'details' => $this->faker->paragraph,
        ], $params));
    }
}
