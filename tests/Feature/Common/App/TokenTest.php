<?php

declare(strict_types=1);

namespace Tests\Feature\Common\App;

use Tests\TestCase;

class TokenTest extends TestCase
{
    /** @test */
    public function itReturnsAToken()
    {
        $this->get('/api/app-request-token')
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }
}
