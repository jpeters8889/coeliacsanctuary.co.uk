<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_register_page()
    {
        $this->get('/member/register')
            ->assertStatus(200)
            ->assertSee('<register-form>', false);
    }
}
