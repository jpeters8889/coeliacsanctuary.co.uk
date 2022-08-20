<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Member\Contracts\Updatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

/**
 * @property mixed $town
 * @property WhereToEatCounty $county
 * @property string $slug
 * @property Collection $liveEateries
 */
class WhereToEatTown extends BaseModel implements Updatable
{
    protected $table = 'wheretoeat_towns';

    protected $visible = ['id', 'town', 'slug', 'county_id'];

    protected static function booted()
    {
        static::creating(static function (self $town) {
            if (! $town->slug) {
                $town->slug = Str::slug($town->town);
                $town->legacy = $town->slug;
            }

            return $town;
        });
    }

    public function eateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'town_id');
    }

    public function liveEateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'town_id')->where('live', true);
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(WhereToEatCounty::class, 'county_id');
    }

    public function getSnippetAttribute(): string
    {
        $eateries = $this->liveEateries->where('type_id', 1)->count();
        $attractions = $this->liveEateries->where('type_id', 2)->count();
        $hotels = $this->liveEateries->where('type_id', 3)->count();

        if ($eateries === 0 && $attractions === 0 && $hotels === 0) {
            return 'No places found';
        }

        $return = [];

        if ($eateries > 0) {
            $return[] = '<strong>'.numberToWords($eateries) . '</strong> gluten free place' . ($eateries > 1 ? 's' : '') . ' to eat';
        }

        if ($attractions > 0) {
            $return[] = '<strong>'.numberToWords($attractions) . '</strong> attraction' . ($attractions > 1 ? 's' : '') . ' with gluten free options';
        }

        if ($hotels > 0) {
            $return[] = '<strong>'.numberToWords($hotels) . '</strong> hotel' . ($hotels > 1 ? 's' : '') . ' / B&B' . ($hotels > 1 ? 's' : '') . ' with gluten free options';
        }

        $last = null;

        if (count($return) > 1) {
            $last = array_pop($return);
        }

        return implode(', ', $return) . ($last ? ' and '. $last : '');
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, WhereToEat::class, 'town_id', 'wheretoeat_id');
    }

    public function updatableName(): string
    {
        return $this->town;
    }

    public function updatableLink(): string
    {
        return "/wheretoeat/{$this->county->slug}/{$this->slug}";
    }
}
