<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property mixed $town
 * @property WhereToEatCounty $county
 * @property string $slug
 */
class WhereToEatTown extends BaseModel
{
    protected $table = 'wheretoeat_towns';

    protected $visible = ['id', 'town', 'slug', 'county_id'];

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

    public function getSnippetAttribute()
    {
        $eateries = $this->liveEateries->where('type_id', 1)->count();
        $attractions = $this->liveEateries->where('type_id', 2)->count();
        $hotels = $this->liveEateries->where('type_id', 3)->count();

        if ($eateries === 0 && $attractions === 0 && $hotels === 0) {
            return 'No places found';
        }

        $return = [];

        if ($eateries > 0) {
            $return[] = $eateries.' Place'.($eateries > 1 ? 's' : '').' to eat';
        }

        if ($attractions > 0) {
            $return[] = $attractions.' Attraction'.($attractions > 1 ? 's' : '');
        }

        if ($hotels > 0) {
            $return[] = $hotels.' Hotel'.($hotels > 1 ? 's' : '').' / B&B'.($hotels > 1 ? 's' : '');
        }

        return implode(', ', $return);
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, WhereToEat::class, 'town_id', 'wheretoeat_id');
    }
}
