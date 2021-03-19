<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TermsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheTermsPage()
    {
        $this->get('/terms-of-use')->assertStatus(200);
    }
}
