<?php

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MemberDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();;
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_redirects_if_we_arent_signed_in()
    {
        $this->get('/member/logout');

        $this->makeRequest()->assertRedirect('/member/login');
    }

    /** @test */
    public function it_redirects_to_the_scrapbook_page_if_hitting_the_dashboard_directly()
    {
        $this->makeRequest()->assertRedirect('/member/dashboard/scrapbooks');
    }

    /**
     * @test
     * @dataProvider pageDataset
     */
    public function it_loads_the_scrapbooks_page($page)
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
