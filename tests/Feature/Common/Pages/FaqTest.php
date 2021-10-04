<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;

class FaqTest extends TestCase
{
    /** @test */
    public function itLoadsTheFaqPage()
    {
        $this->get('/faq')->assertStatus(200);
    }
}
