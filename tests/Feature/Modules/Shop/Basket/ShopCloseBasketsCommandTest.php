<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Basket;

use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Events\BasketClosed;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class ShopCloseBasketsCommandTest extends TestCase
{
    protected ShopOrder $basket;

    protected function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();

        $this->basket = $this->build(ShopOrder::class)
            ->asBasket()
            ->create();
    }

    /** @test */
    public function itDoesntCloseCurrentOpenBaskets()
    {
        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);
    }

    /** @test */
    public function itDoesntCloseBasketsLessThanAnHourOld()
    {
        TestTime::addMinutes(59);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);
    }

    /** @test */
    public function itClosesBasketsThatAreOverAnHourOld()
    {
        TestTime::addMinutes(61);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_EXPIRED, $this->basket->state_id);
    }

    /** @test */
    public function itDoesntCloseABasketIfItHasBeenUpdatedInThePastHour()
    {
        TestTime::addMinutes(59);

        $this->basket->touch();

        TestTime::addMinutes(2);

        $this->runCommand();

        $this->assertEquals(ShopOrderState::STATE_BASKET, $this->basket->state_id);
    }

    /** @test */
    public function itClosesABasketAfterAnHourOfNoActivity()
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
    public function itDoesntCloseNonBaskets()
    {
        $this->basket->markAs(ShopOrderState::STATE_PAID);

        TestTime::addMinutes(61);

        $this->runCommand();

        $this->assertNotEquals(ShopOrderState::STATE_EXPIRED, $this->basket->state_id);
    }

    /** @test */
    public function itEmitsAnEventWhenABasketIsClosed()
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
