<?php

namespace Tests\Feature;

use Tests\TestCase;

class TokenTest extends TestCase
{
    /** @test */
    public function it_returns_a_token()
    {
        $this->get('/api/app-request-token')
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }
}
