<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;

class TermsTest extends TestCase
{
    /** @test */
    public function itLoadsTheTermsPage()
    {
        $this->get('/terms-of-use')->assertStatus(200);
    }
}
