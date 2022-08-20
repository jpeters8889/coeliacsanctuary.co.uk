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

/**
 * @property string            $county
 * @property WhereToEatCountry $country
 * @property mixed             $slug
 * @property mixed             $reviews_count
 * @property Collection $activeTowns
 * @property int $id
 */
class WhereToEatCounty extends BaseModel implements Updatable
{
    protected $table = 'wheretoeat_counties';

    protected $visible = ['id', 'county', 'slug'];

    public function activeTowns(): HasMany
    {
        return $this->hasMany(WhereToEatTown::class, 'county_id')->whereHas('liveEateries')->orderBy('town');
    }

    public function eateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'county_id');
    }

    public function towns(): HasMany
    {
        return $this->hasMany(WhereToEatTown::class, 'county_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(WhereToEatCountry::class, 'country_id');
    }

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, WhereToEat::class, 'county_id', 'wheretoeat_id');
    }

    public function updatableName(): string
    {
        return $this->county;
    }

    public function updatableLink(): string
    {
        return "/wheretoeat/{$this->slug}";
    }
}
