<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Announcements;

use Carbon\Carbon;
use Tests\TestCase;
use Coeliac\Common\Models\Announcement;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itDoesntShowAnAnnouncentWhenThereIsntAnyAnnouncements()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);

        $this->get('/about')
            ->assertStatus(200)
            ->assertDontSee('<announcement>', false);
    }

    /** @test */
    public function itDoesntShowAnAnnouncementWhenItIsntLive()
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
    public function itDoesntShowAnAnnouncementThatHasExpired()
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
    public function itLoadsAnAnnouncement()
    {
        $announcement = factory(Announcement::class)->create();

        $this->get('/')
            ->assertStatus(200)
            ->assertSee('<global-layout-announcement>', false)
            ->assertSee($announcement->title, false)
            ->assertSee($announcement->text, false);

        $this->get('/about')
            ->assertStatus(200)
            ->assertSee('<global-layout-announcement>', false)
            ->assertSee($announcement->title, false)
            ->assertSee($announcement->text, false);
    }
}
