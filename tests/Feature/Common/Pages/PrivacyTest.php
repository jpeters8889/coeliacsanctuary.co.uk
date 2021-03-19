<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PrivacyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsThePrivacyPage()
    {
        $this->get('/privacy-policy')->assertStatus(200);
    }
}
