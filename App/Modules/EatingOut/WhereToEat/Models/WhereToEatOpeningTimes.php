<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * @property string $country
 * @property string $monday_start
 * @property string $monday_end
 * @property string $tuesday_start
 * @property string $tuesday_end
 * @property string $wednesday_start
 * @property string $wednesday_end
 * @property string $thursday_start
 * @property string $thursday_end
 * @property string $friday_start
 * @property string $friday_end
 * @property string $saturday_start
 * @property string $saturday_end
 * @property string $sunday_start
 * @property string $sunday_end
 * @property string $opens_at
 * @property string $closes_at
 * @property bool $is_open_now
 */
class WhereToEatOpeningTimes extends BaseModel
{
    protected $appends = ['is_open_now', 'opens_at', 'closes_at'];

    protected $casts = ['is_open_now' => 'bool'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'wheretoeat_opening_times';

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id');
    }

    public function getIsOpenNowAttribute(): bool
    {
        $today = $this->currentDay();

        $todaysOpeningTime = $this->formatTime($today . '_start');
        $todaysClosingTime = $this->formatTime($today . '_end');

        if (!$todaysOpeningTime) {
            return false;
        }

        $opensAt = Carbon::now()->clone()->setTime(...$todaysOpeningTime);
        $closesAt = Carbon::now()->clone()->setTime(...$todaysClosingTime);

        if ($closesAt->hour < $opensAt->hour) {
            $closesAt->addDay()->startOfDay();
        }

        return Carbon::now()->isBetween($opensAt, $closesAt);
    }

    public function getClosesAtAttribute(): string|null
    {
        if (!$this->is_open_now) {
            return null;
        }

        $today = $this->currentDay();

        return $this->timeToString($today, 'end');
    }

    public function getOpensAtAttribute(): string|null
    {
        if (!$this->is_open_now) {
            return null;
        }

        $today = $this->currentDay();

        return $this->timeToString($today, 'start');
    }

    public function formatTime(string $column): array|null
    {
        $value = $this->$column;

        if (!$value) {
            return null;
        }

        $bits = explode(':', $value);

        return [
            (int)$bits[0],
            (int)($bits[1] ?? 0),
            (int)($bits[2] ?? 0),
        ];
    }

    protected function timeToString(string $today, $suffix): string
    {
        $closesAt = $this->formatTime("{$today}_{$suffix}");

        if ($closesAt[1] === 0) {
            if ($closesAt[0] === 0) {
                return 'midnight';
            }

            if ($closesAt[0] === 12) {
                return 'midday';
            }

            $suffix = $closesAt[0] < 12 ? 'am' : 'pm';

            return ($closesAt[0] > 12 ? $closesAt[0] - 12 : $closesAt[0]) . $suffix;
        }

        return "{$closesAt[0]}:{$closesAt[1]}";
    }

    protected function currentDay(): string
    {
        return Str::lower(Carbon::now()->dayName);
    }
}
