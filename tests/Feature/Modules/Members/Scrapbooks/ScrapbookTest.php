<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Scrapbooks;

use Spatie\TestTime\TestTime;
use Tests\Abstracts\DashboardTest;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\Scrapbook;

class ScrapbookTest extends DashboardTest
{
    protected Scrapbook $scrapbook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scrapbook = $this->build(Scrapbook::class)
            ->in($this->user)
            ->create();
    }

    protected function page(): string
    {
        return 'scrapbooks';
    }

    /** @test */
    public function itLoadsTheScrapbookListEndpoint()
    {
        $this->makeApiRequest()->assertOk();
    }

    /** @test */
    public function itReturnsTheScrapbooksInTheExpectedFormat()
    {
        $request = $this->makeApiRequest();

        $this->assertIsArray($request->json());
        $this->assertCount(1, $request->json());

        $request->assertJsonFragment(['user_id' => $this->user->id]);
        $request->assertJsonFragment(['name' => 'My Scrapbook']);
        $request->assertJsonFragment(['items_count' => 0]);
    }

    /** @test */
    public function itOnlyShowsTheLoggedInUsersScrapbooks()
    {
        $this->create(Scrapbook::class, ['name' => 'Another Scrapbook']);

        $this->makeApiRequest()
            ->assertJsonCount(1)
            ->assertJsonMissing(['name' => 'Another Scrapbook']);
    }

    /** @test */
    public function itErrorsWhenTryingToCreateANewScrapbookWithoutAName()
    {
        $this->post('/api/member/dashboard/scrapbooks')->assertStatus(422);
    }

    /** @test */
    public function itCreatesANewScrapbook()
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
    public function itErrorsWhenTryingToUpdateTheNameWithANullName()
    {
        $this->patch("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")->assertStatus(422);
    }

    /** @test */
    public function itCanHaveItsNameChanged()
    {
        $this->patch("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}", [
            'name' => 'Updated Name',
        ])->assertOk();

        $this->assertEquals('Updated Name', $this->scrapbook->fresh()->name);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateSomeoneElsesScrapbook()
    {
        $scrapbook = $this->create(Scrapbook::class);

        $this->patch("/api/member/dashboard/scrapbooks/{$scrapbook->id}", [
            'name' => 'foo',
        ])->assertStatus(403);

        $this->assertNotEquals('foo', $scrapbook->fresh()->name);
    }

    /** @test */
    public function itCantDeleteAScrapbookIfTheresOnlyOneScrapbook()
    {
        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")->assertStatus(422);

        $this->assertCount(1, Scrapbook::all());
    }

    /** @test */
    public function itCanDeleteAScrapbook()
    {
        $scrapbook = $this->build(Scrapbook::class)
            ->in($this->user)
            ->create();

        $this->assertCount(2, Scrapbook::all());

        $this->delete("/api/member/dashboard/scrapbooks/{$scrapbook->id}")->assertOk();

        $this->assertCount(1, Scrapbook::all());
    }

    /** @test */
    public function itErrorsWhenTryingToDeleteAnotherUsersScrapbook()
    {
        $scrapbook = $this->create(Scrapbook::class);

        $this->assertCount(2, Scrapbook::all());

        $this->delete("/api/member/dashboard/scrapbooks/{$scrapbook->id}")->assertStatus(403);

        $this->assertCount(2, Scrapbook::all());
    }
}
