<?php

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Carbon\Carbon;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatOpeningTimes;
use Spatie\TestTime\TestTime;
use Tests\TestCase;

class WhereToEatOpeningTimesTest extends TestCase
{
    /**
     * @test
     * @dataProvider days
     */
    public function itReturnsEachOpeningTimeAsAnArrayWithThreeBits($day): void
    {
        $openingTime = $this->create(WhereToEatOpeningTimes::class);

        $this->assertIsArray($openingTime->{$day.'_start'});
        $this->assertIsArray($openingTime->{$day.'_end'});
        $this->assertCount(3, $openingTime->{$day.'_start'});
        $this->assertCount(3, $openingTime->{$day.'_end'});
    }

    public function days(): array
    {
        return [['monday'], ['tuesday'], ['wednesday'], ['thursday'], ['friday'], ['saturday'], ['sunday']];
    }

    /** @test */
    public function itReturnsAnIsOpenAttribute(): void
    {
        $openingTime = $this->create(WhereToEatOpeningTimes::class);

        $this->assertIsBool($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsNotOpenIfThereIsNoOpeningTimesForTheGivenDay(): void
    {
        $today = Carbon::now()->dayName;

        $openingTime = $this->create(WhereToEatOpeningTimes::class, ["{$today}_start" => null]);

        $this->assertFalse($openingTime->is_open_now);
    }

    /** @test */
    public function itReturnsAsClosedIfBeforeOpeningTimes(): void
    {
        TestTime::freeze();

        $today = Carbon::now()->dayName;

        $openingTime = $this->create(WhereToEatOpeningTimes::class, ["{$today}_start" => '12:00']);

        TestTime::setHour(10);

        $this->assertFalse($openingTime->is_open_now);
    }
}
