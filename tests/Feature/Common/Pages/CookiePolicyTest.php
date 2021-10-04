<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;

class CookiePolicyTest extends TestCase
{
    /** @test */
    public function itLoadsTheCookiePage()
    {
        $this->get('/cookie-policy')->assertStatus(200);
    }
}
