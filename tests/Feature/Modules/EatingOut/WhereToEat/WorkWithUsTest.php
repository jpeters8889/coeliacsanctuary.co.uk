<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkWithUsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itLoadsTheWorkWithUsPage()
    {
        $this->get('/work-with-us')->assertStatus(200);
    }
}
