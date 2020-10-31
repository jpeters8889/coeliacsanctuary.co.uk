<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkWithUsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_loads_the_work_with_us_page()
    {
        $this->get('/work-with-us')->assertStatus(200);
    }
}
