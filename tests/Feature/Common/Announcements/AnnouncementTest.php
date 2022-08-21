<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Announcements;

use Coeliac\Common\Models\Announcement;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
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
        $this->build(Announcement::class)->hidden()->create();

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
        $this->build(Announcement::class)->hasExpired()->create();

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
        $announcement = $this->create(Announcement::class);

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
