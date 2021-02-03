<?php

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_logs_out_users()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());

        $this->get('/member/logout')->assertRedirect('/');

        $this->assertFalse($this->isAuthenticated());
    }
}
