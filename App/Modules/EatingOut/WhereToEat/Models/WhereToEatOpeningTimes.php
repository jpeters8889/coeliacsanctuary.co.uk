<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\WhereToEat\Casts\OpeningTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $country
 */
class WhereToEatOpeningTimes extends BaseModel
{
    protected $appends = ['is_open_now'];

    protected $casts = [
        'monday_start' => OpeningTime::class,
        'monday_end' => OpeningTime::class,
        'tuesday_start' => OpeningTime::class,
        'tuesday_end' => OpeningTime::class,
        'wednesday_start' => OpeningTime::class,
        'wednesday_end' => OpeningTime::class,
        'thursday_start' => OpeningTime::class,
        'thursday_end' => OpeningTime::class,
        'friday_start' => OpeningTime::class,
        'friday_end' => OpeningTime::class,
        'saturday_start' => OpeningTime::class,
        'saturday_end' => OpeningTime::class,
        'sunday_start' => OpeningTime::class,
        'sunday_end' => OpeningTime::class,
        'is_open_now' => 'bool'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'wheretoeat_opening_times';

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id');
    }

    public function getIsOpenNowAttribute(): bool
    {
        $now = Carbon::now();

        $todaysOpeningTime = $this->{$now->dayName.'_start'};
        $todaysClosingTime = $this->{$now->dayName.'_end'};

        if(!$todaysOpeningTime) {
            return false;
        }

        dd($todaysOpeningTime);

        $opensAt = $now->clone()->setTime(...$todaysOpeningTime);
        $closesAt = $now->clone()->setTime(...$todaysClosingTime);

        return $now->isBetween($opensAt, $closesAt);

    }
}
