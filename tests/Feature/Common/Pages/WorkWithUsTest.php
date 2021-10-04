<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Pages;

use Tests\TestCase;

class WorkWithUsTest extends TestCase
{
    /** @test */
    public function itLoadsTheWorkWithUsPage()
    {
        $this->get('/work-with-us')->assertStatus(200);
    }
}
