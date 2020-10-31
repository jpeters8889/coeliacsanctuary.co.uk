<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CookiePolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_privacy_page()
    {
        $this->get('/cookie-policy')->assertStatus(200);
    }
}
