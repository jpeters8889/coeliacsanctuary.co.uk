<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Container\Container;
use Coeliac\Common\Traits\ClearsCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed                            $name
 * @property WhereToEatTown                   $town
 * @property WhereToEatCounty                 $county
 * @property mixed                            $info
 * @property mixed                            $address
 * @property mixed                            $lat
 * @property mixed                            $lng
 * @property mixed                            $live
 * @property mixed                            $id
 * @property Collection<AttractionRestaurant> $restaurants
 * @property mixed                            $website
 * @property WhereToEatCuisine                $cuisine
 * @property mixed                            $phone
 * @property WhereToEatCountry                $country
 * @property mixed                            $type_id
 * @property mixed                            $review_count
 *
 * @method transform(array $array)
 */
class WhereToEat extends BaseModel
{
    use ClearsCache;
    use Searchable;

    protected $appends = [
        'average_rating',
        'has_been_rated',
        'icon',
        'full_name',
        'full_location',
        'type_description',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'wheretoeat';

//    protected $with = ['ratings'];

    public function town(): BelongsTo
    {
        return $this->belongsTo(WhereToEatTown::class, 'town_id');
    }

    public function county(): BelongsTo
    {
        return $this->belongsTo(WhereToEatCounty::class, 'county_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(WhereToEatCountry::class, 'country_id');
    }

    public function features()
    {
        return $this->belongsToMany(
            WhereToEatFeature::class,
            'wheretoeat_assigned_features',
            'wheretoeat_id',
            'feature_id'
        )->withTimestamps();
    }

    public function getAverageRatingAttribute()
    {
        if (!$this->relationLoaded('ratings')) {
            return null;
        }

        return (string) array_average($this->ratings->pluck('rating')->toArray());
    }

    public function getHasBeenRatedAttribute()
    {
        if (!$this->relationLoaded('ratings')) {
            return null;
        }

        return $this->ratings
                ->where('ip', Container::getInstance()->make(Request::class)->ip())
                ->count() > 0;
    }

    public function getIconAttribute()
    {
        if (!$this->type) {
            return null;
        }

        $file = 'place-to-eat.png';

        if ($this->type->type === 'att') {
            $file = 'attraction.png';
        }

        if ($this->type->type === 'hotel') {
            $file = 'hotel.png';
        }

        return asset('assets/images/wte-icons/'.$file);
    }

    public function venueType(): HasOne
    {
        return $this->hasOne(WhereToEatVenueType::class, 'id', 'venue_type_id');
    }

    public function cuisine(): HasOne
    {
        return $this->hasOne(WhereToEatCuisine::class, 'id', 'cuisine_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(WhereToEatType::class, 'id', 'type_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'wheretoeat_id', 'id');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(WhereToEatRating::class, 'wheretoeat_id', 'id');
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(AttractionRestaurant::class, 'wheretoeat_id', 'id');
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->name.', '.$this->town->town,
            'location' => $this->town->town.', '.$this->county->county,
            'town' => $this->town->town,
            'county' => $this->county->county,
            'description' => $this->info,
            'address' => $this->address,
            'features' => $this->features()->get()->transform(static function (WhereToEatFeature $feature) {
                return $feature->feature;
            })->join(', '),
            '_geoloc' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ],
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return $this->live === 1;
    }

    public function getScoutKey()
    {
        return $this->id;
    }

    public function getFullNameAttribute()
    {
        return implode(', ', [
            $this->name,
            $this->town->town,
            $this->county->county,
            $this->country->country,
        ]);
    }

    public function getFullLocationAttribute()
    {
        return implode(', ', [
            $this->town->town,
            $this->county->county,
            $this->country->country,
        ]);
    }

    public function getTypeDescriptionAttribute()
    {
        return $this->type->name;
    }

    protected function cacheKey(): string
    {
        return 'wheretoeat';
    }
}
