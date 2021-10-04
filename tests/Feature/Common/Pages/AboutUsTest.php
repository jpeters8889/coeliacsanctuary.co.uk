<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;

class AboutUsTest extends TestCase
{
    /** @test */
    public function itLoadsTheAboutIndexPage()
    {
        $this->get('/about')->assertStatus(200);
    }
}
