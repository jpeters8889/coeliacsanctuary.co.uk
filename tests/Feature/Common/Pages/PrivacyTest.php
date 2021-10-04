<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;

class PrivacyTest extends TestCase
{
    /** @test */
    public function itLoadsThePrivacyPage()
    {
        $this->get('/privacy-policy')->assertStatus(200);
    }
}
