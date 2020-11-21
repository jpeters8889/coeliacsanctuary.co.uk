<?php

declare(strict_types=1);

namespace Tests\Architect;

use Tests\TestCase;
use Coeliac\Common\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;

class PlaceRequestApiCallTest extends TestCase
{
    use RefreshDatabase;
    use LogsInUsers;

    private ?PlaceRequest $placeRequest = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logIn(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));

        $this->placeRequest = factory(PlaceRequest::class)->create();
    }

    /** @test */
    public function it_can_be_deleted()
    {
        $this->delete('/cs-adm/api/external/coeliac-place-request/delete/'.$this->placeRequest->id);

        $this->assertDeleted($this->placeRequest);
    }

    /** @test */
    public function it_can_be_approved()
    {
        $this->assertEquals(0, $this->placeRequest->completed);

        $this->put('/cs-adm/api/external/coeliac-place-request/complete/'.$this->placeRequest->id);

        $this->assertEquals(1, $this->placeRequest->fresh()->completed);
    }
}
