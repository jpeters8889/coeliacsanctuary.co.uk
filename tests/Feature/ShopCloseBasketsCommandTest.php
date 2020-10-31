<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopCloseBasketsCommandTest extends TestCase
{
    use RefreshDatabase;

    protected ShopOrder $basket;

    protected function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();
        $this->basket = ShopOrder::query()->create([
            'token' => 'foo',
            'state_id' => ShopOrderState::STATE_BASKET,
        ]);
    }

    /** @test */
    public function it_doesnt_close_current_open_baskets()
    {
        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);
    }

    /** @test */
    public function it_doesnt_close_baskets_less_than_an_hour_old()
    {
        TestTime::addMinutes(59);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);
    }

    /** @test */
    public function it_closes_baskets_that_are_over_an_hour_old()
    {
        TestTime::addMinutes(61);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_EXPIRED, $this->basket->state_id);
    }

    /** @test */
    public function it_doesnt_close_a_basket_if_it_has_been_updated_in_the_past_hour()
    {
        TestTime::addMinutes(59);

        $this->basket->touch();

        TestTime::addMinutes(2);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);
    }

    /** @test */
    public function it_closes_a_basket_after_an_hour_of_no_activity()
    {
        TestTime::addMinutes(30);

        $this->basket->touch();

        TestTime::addMinutes(31);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);

        TestTime::addMinutes(30);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_EXPIRED, $this->basket->state_id);
    }

    /** @test */
    public function it_doesnt_close_non_baskets()
    {
        $this->basket->markAs(ShopOrderState::STATE_PAID);

        TestTime::addMinutes(61);

        $this->runCommand();

        $this->assertNotEquals(ShopOrderState::STATE_EXPIRED, $this->basket->state_id);
    }

    /** @test */
    public function it_emits_an_event_when_a_basket_is_closed()
    {
        Event::fake();

        TestTime::addMinutes(61);

        $this->runCommand();

        Event::assertDispatched(BasketClosed::class);
    }

    protected function runCommand(): void
    {
        $this->artisan('coeliac:shopCloseBaskets');
        $this->basket->refresh();
    }
}
