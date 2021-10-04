<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Login;

use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;

class LogoutTest extends TestCase
{
    /** @test */
    public function itLogsOutUsers()
    {
        $this->actingAs($this->create(User::class));

        $this->get('/member/logout')->assertRedirect('/');

        $this->assertFalse($this->isAuthenticated());
    }
}
