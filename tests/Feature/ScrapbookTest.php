<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
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
}
