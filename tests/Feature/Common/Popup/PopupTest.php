<?php

declare(strict_types=1);

namespace Tests\Feature\Common\Popup;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Spatie\TestTime\TestTime;
use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Popup;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PopupTest extends TestCase
{
    use HasImages;
    use RefreshDatabase;

    protected function createPopup($data = [])
    {
        /** @var Popup $popup */
        $popup = factory(Popup::class)->create($data);
        $popup->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_POPUP);

        return $popup;
    }

    /** @test */
    public function itLoadsTheEndpoint()
    {
        $this->get('/api/popup')->assertStatus(200);
    }

    /** @test */
    public function itLoadsAnEmptyDatasetWhenNoPopupsAreAvailable()
    {
        $this->get('/api/popup')->assertJson([]);
    }

    /** @test */
    public function itLoadsAPopupWhenRequired()
    {
        $popup = $this->createPopup();

        $this->get('/api/popup')
            ->assertStatus(200)
            ->assertJson($popup->toArray());
    }

    /** @test */
    public function itLoadsAPopupRepeatedlyUntilItIsSeen()
    {
        TestTime::freeze();
        $popup = $this->createPopup(['display_every' => 7]);

        $this->get('/api/popup')->assertJson($popup->toArray());

        TestTime::addHour();
        $this->get('/api/popup')->assertJson($popup->toArray());

        TestTime::addDay();
        $this->get('/api/popup')->assertJson($popup->toArray());
    }

    /** @test */
    public function itCanMarkAPopupAsBeingSeen()
    {
        $popup = $this->createPopup();

        $this->patch("/api/popup/{$popup->id}")->assertStatus(200);
    }

    /** @test */
    public function itCreatesACookieStatingThatAPopupHasBeenSeen()
    {
        $popup = $this->createPopup();

        $this->patch("/api/popup/{$popup->id}")->assertCookie("CS_SEEN_POPUP_{$popup->id}");
    }

    /** @test */
    public function itStoresTheCorrectTimestampInTheCookie()
    {
        TestTime::freeze();

        $popup = $this->createPopup();

        $this->patch("/api/popup/{$popup->id}")
            ->assertCookie("CS_SEEN_POPUP_{$popup->id}", Carbon::now()->timestamp);
    }

    /** @test */
    public function itDoesntShowAPopupWhenItHasBeenSeenInTheAllocatedTime()
    {
        TestTime::freeze();

        $popup = $this->createPopup(['display_every' => 1]);

        $this->withCookie("CS_SEEN_POPUP_{$popup->id}", $now = (string) Carbon::now()->timestamp);

        $this->get('/api/popup')->assertJson([]);

        TestTime::addHour();
        $this->get('/api/popup')->assertJson([]);

        TestTime::addDays(2);
        $this->get('/api/popup')->assertJson($popup->toArray());
    }
}
