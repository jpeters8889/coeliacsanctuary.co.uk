<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AboutUsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_about_index_page()
    {
        $this->get('/about')->assertStatus(200);
    }
}
