<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceRequest as PlaceRequestMailable;

class WhereToEatPlaceRequestTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->setUpFaker();
    }

    /** @test */
    public function it_loads_the_page()
    {
        $this->get('/wheretoeat/place-request')
            ->assertStatus(200)
            ->assertSee('<wheretoeat-place-request-form></wheretoeat-place-request-form', false);
    }

    /** @test */
    public function it_errors_without_a_name()
    {
        $this->makeCreateRequest(['name' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function it_errors_without_a_state()
    {
        $this->makeCreateRequest(['state' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_invalid_state()
    {
        $this->makeCreateRequest(['state' => 'foo'])
            ->assertStatus(422);
    }

    /** @test */
    public function it_errors_without_any_comments()
    {
        $this->makeCreateRequest(['comment' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function it_returns_a_succesful_response_when_all_valid_data_is_sent()
    {
        Event::fake();

        $this->makeCreateRequest()->assertStatus(200);
    }

    /** @test */
    public function it_stores_the_data_in_the_database()
    {
        Event::fake();

        $params = [
            'name' => $this->faker->name,
            'state' => $this->faker->randomElement(['add', 'remove']),
            'comment' => $this->faker->paragraph,
        ];

        $this->makeCreateRequest($params);

        $this->assertCount(1, PlaceRequest::query()->get());
    }

    /** @test */
    public function it_emits_an_event_when_a_request_is_received()
    {
        Event::fake();

        $this->makeCreateRequest();

        Event::assertDispatched(PlaceRequestSubmitted::class);
    }

    /** @test */
    public function it_triggers_an_email_when_a_request_is_recieved()
    {
        Mail::fake();

        $this->makeCreateRequest();

        Mail::assertSent(PlaceRequestMailable::class);
    }

    private function makeCreateRequest($params = [])
    {
        return $this->post('/api/wheretoeat/place-request', array_merge([
            'name' => $this->faker->name,
            'state' => $this->faker->randomElement(['add', 'remove']),
            'comment' => $this->faker->paragraph,
        ], $params));
    }
}
