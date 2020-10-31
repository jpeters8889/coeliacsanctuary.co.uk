<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Coeliac\Common\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_doesnt_show_an_announcent_when_there_isnt_any_announcements()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);

        $this->get('/about')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);
    }

    /** @test */
    public function it_doesnt_show_an_announcement_when_it_isnt_live()
    {
        factory(Announcement::class)->create(['live' => false]);

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);

        $this->get('/about')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);
    }

    /** @test */
    public function it_doesnt_show_an_announcement_that_has_expired()
    {
        factory(Announcement::class)->create(['expires_at' => Carbon::now()->subHour()]);

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);

        $this->get('/about')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);
    }

    /** @test */
    public function it_loads_an_announcement()
    {
        $announcement = factory(Announcement::class)->create();

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('<announcement>', false)
            ->assertSee($announcement->title, false)
            ->assertSee($announcement->text, false);

        $this->get('/about')
            ->assertStatus(200)
            ->assertSee('<announcement>', false)
            ->assertSee($announcement->title, false)
            ->assertSee($announcement->text, false);
    }
}
