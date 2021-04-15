<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Dashboard;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function itRedirectsIfWeArentSignedIn()
    {
        $this->get('/member/logout');

        $this->makeRequest()->assertRedirect('/member/login');
    }

    /** @test */
    public function itRedirectsToTheScrapbookPageIfHittingTheDashboardDirectly()
    {
        $this->makeRequest()->assertRedirect('/member/dashboard/scrapbooks');
    }

    /**
     * @test
     * @dataProvider pageDataset
     */
    public function itLoadsTheScrapbooksPage($page)
    {
        $this->withoutExceptionHandling();
        $this->makeRequest($page)->assertOk();
    }

    public function pageDataset()
    {
        return [
            ['scrapbooks'],
            ['orders'],
            ['daily-updates'],
            ['details'],
        ];
    }

    protected function makeRequest($page = ''): TestResponse
    {
        return $this->get("/member/dashboard/{$page}");
    }
}
