<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Dashboard;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Coeliac\Modules\Member\Models\User;

class MemberDashboardTest extends TestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->create(User::class);
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
