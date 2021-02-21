<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
use Spatie\TestTime\TestTime;
use Tests\Abstracts\DashboardTest;
use Coeliac\Modules\Member\Models\Scrapbook;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScrapbookTest extends DashboardTest
{
    use RefreshDatabase;

    protected Scrapbook $scrapbook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scrapbook = factory(Scrapbook::class)->create(['user_id' => $this->user->id]);
    }

    protected function page(): string
    {
        return 'scrapbooks';
    }

    /** @test */
    public function it_loads_the_scrapbook_list_endpoint()
    {
        $this->makeApiRequest()->assertOk();
    }

    /** @test */
    public function it_returns_the_scrapbooks_in_the_expected_format()
    {
        $request = $this->makeApiRequest();

        $this->assertIsArray($request->json());
        $this->assertCount(1, $request->json());

        $request->assertJsonFragment(['user_id' => 1]);
        $request->assertJsonFragment(['name' => 'My Scrapbook']);
        $request->assertJsonFragment(['items_count' => '0']);
    }

    /** @test */
    public function it_only_shows_the_logged_in_users_scrapbooks()
    {
        factory(Scrapbook::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'name' => 'Another Scrapbook',
        ]);

        $this->makeApiRequest()
            ->assertJsonCount(1)
            ->assertJsonMissing(['name' => 'Another Scrapbook']);
    }

    /** @test */
    public function it_errors_when_trying_to_create_a_new_scrapbook_without_a_name()
    {
        $this->post('/api/member/dashboard/scrapbooks')->assertStatus(422);
    }

    /** @test */
    public function it_creates_a_new_scrapbook()
    {
        $this->assertCount(1, $this->user->scrapbooks);

        TestTime::freeze()->addHour();

        $this->post('/api/member/dashboard/scrapbooks', [
            'name' => 'New Scrapbook',
        ])->assertOk();

        $this->assertCount(2, $this->user->fresh()->scrapbooks);
        $this->assertEquals('New Scrapbook', Scrapbook::query()->latest()->first()->name);
    }

    /** @test */
    public function it_errors_when_trying_to_update_the_name_with_a_null_name()
    {
        $this->patch("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")->assertStatus(422);
    }

    /** @test */
    public function it_can_have_its_name_changed()
    {
        $this->patch("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}", [
           'name' => 'Updated Name',
        ])->assertOk();

        $this->assertEquals('Updated Name', $this->scrapbook->fresh()->name);
    }

    /** @test */
    public function it_errors_when_trying_to_update_someone_elses_scrapbook()
    {
        $scrapbook = factory(Scrapbook::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'name' => 'Another Scrapbook',
        ]);

        $this->patch("/api/member/dashboard/scrapbooks/{$scrapbook->id}", [
            'name' => 'foo'
        ])->assertStatus(403);

        $this->assertNotEquals('foo', $scrapbook->fresh()->name);
    }

    /** @test */
    public function it_cant_delete_a_scrapbook_if_theres_only_one_scrapbook()
    {
        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")->assertStatus(422);

        $this->assertCount(1, Scrapbook::all());
    }

    /** @test */
    public function it_can_delete_a_scrapbook()
    {
        $scrapbook = factory(Scrapbook::class)->create(['user_id' => $this->user->id]);

        $this->assertCount(2, Scrapbook::all());

        $this->delete("/api/member/dashboard/scrapbooks/{$scrapbook->id}")->assertOk();

        $this->assertCount(1, Scrapbook::all());
    }

    /** @test */
    public function it_errors_when_trying_to_delete_another_users_scrapbook()
    {
        $scrapbook = factory(Scrapbook::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'name' => 'Another Scrapbook',
        ]);

        $this->assertCount(2, Scrapbook::all());

        $this->delete("/api/member/dashboard/scrapbooks/{$scrapbook->id}")->assertStatus(403);

        $this->assertCount(2, Scrapbook::all());
    }
}
