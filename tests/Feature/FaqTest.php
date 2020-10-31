<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_faq_page()
    {
        $this->get('/faq')->assertStatus(200);
    }
}
