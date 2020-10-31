<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TermsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_terms_page()
    {
        $this->get('/terms-of-use')->assertStatus(200);
    }
}
