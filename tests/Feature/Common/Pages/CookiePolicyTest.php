<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CookiePolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheCookiePage()
    {
        $this->get('/cookie-policy')->assertStatus(200);
    }
}
