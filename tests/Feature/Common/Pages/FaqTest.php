<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheFaqPage()
    {
        $this->get('/faq')->assertStatus(200);
    }
}
