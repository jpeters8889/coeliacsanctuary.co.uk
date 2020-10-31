<?php

declare(strict_types=1);

namespace Tests\Feature;

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
    public function it_loads_the_endpoint()
    {
        $this->get('/api/popup')->assertStatus(200);
    }

    /** @test */
    public function it_loads_an_empty_dataset_when_no_popups_are_available()
    {
        $this->get('/api/popup')->assertJson([]);
    }

    /** @test */
    public function it_loads_a_popup_when_required()
    {
        $popup = $this->createPopup();

        $this->get('/api/popup')
            ->assertStatus(200)
            ->assertJson($popup->toArray());
    }

    /** @test */
    public function it_loads_a_popup_repeatedly_until_it_is_seen()
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
    public function it_can_mark_a_popup_as_being_seen()
    {
        $popup = $this->createPopup();

        $this->patch("/api/popup/{$popup->id}")->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_cookie_stating_that_a_popup_has_been_seen()
    {
        $popup = $this->createPopup();

        $this->patch("/api/popup/{$popup->id}")->assertCookie("CS_SEEN_POPUP_{$popup->id}");
    }

    /** @test */
    public function it_stores_the_correct_timestamp_in_the_cookie()
    {
        TestTime::freeze();

        $popup = $this->createPopup();

        $this->patch("/api/popup/{$popup->id}")
            ->assertCookie("CS_SEEN_POPUP_{$popup->id}", Carbon::now()->timestamp);
    }

    /** @test */
    public function it_doesnt_show_a_popup_when_it_has_been_seen_in_the_allocated_time()
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
