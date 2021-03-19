<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AboutUsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheAboutIndexPage()
    {
        $this->get('/about')->assertStatus(200);
    }
}
