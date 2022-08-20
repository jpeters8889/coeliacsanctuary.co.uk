<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\DisplaysImages;
use Coeliac\Common\Traits\Imageable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property string $name
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $terms
 */
class Competition extends BaseModel
{
    use ArchitectModel;
    use Imageable;
    use DisplaysImages;

    protected $casts = [
        'enable_facebook_like' => 'bool',
        'enable_facebook_share' => 'bool',
        'enable_twitter_follow' => 'bool',
        'enable_twitter_tweet' => 'bool',
        'enable_shop_purchase' => 'bool',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function resolveRouteBinding($value, $field = null): self|Model|null
    {
        $column = 'slug';

        if (Str::contains(request()->url(), 'api/')) {
            $column = 'uuid';
        }

        return $this->newQuery()->where($column, $value)->firstOrFail();
    }

    protected static function booted()
    {
        static::creating(function (self $competition) {
            $competition->uuid = Str::uuid()->toString();
        });
    }

    public function isActive(): bool
    {
        $now = Carbon::now();

        if ($this->start_at->isFuture() && $this->start_at->subWeek()->gte($now)) {
            return false;
        }

        if ($this->end_at->isPast() && $this->end_at->addWeeks(4)->lte($now)) {
            return false;
        }

        return true;
    }

    public function isOpenForEntries(): bool
    {
        $now = Carbon::now();

        return $now->gte($this->start_at) && $now->lte($this->end_at);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(CompetitionEntry::class);
    }

    protected static function usesImages(): bool
    {
        return false;
    }

    protected static function bodyField(): string
    {
        return 'description';
    }

    protected static function titleField(): string
    {
        return 'name';
    }
}
