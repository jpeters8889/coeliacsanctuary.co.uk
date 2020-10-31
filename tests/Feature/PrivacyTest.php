<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrivacyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_privacy_page()
    {
        $this->get('/privacy-policy')->assertStatus(200);
    }
}
