<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Login;

use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLogsOutUsers()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());

        $this->get('/member/logout')->assertRedirect('/');

        $this->assertFalse($this->isAuthenticated());
    }
}
