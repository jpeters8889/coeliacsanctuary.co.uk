<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Scout\Searchable;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Container\Container;
use Coeliac\Common\Traits\ClearsCache;
use Illuminate\Database\Eloquent\Collection;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Member\Traits\CreatesDailyUpdate;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $name
 * @property WhereToEatTown $town
 * @property WhereToEatCounty $county
 * @property mixed $info
 * @property mixed $address
 * @property mixed $lat
 * @property mixed $lng
 * @property mixed $live
 * @property mixed $id
 * @property Collection<AttractionRestaurant> $restaurants
 * @property mixed $website
 * @property WhereToEatCuisine $cuisine
 * @property mixed $phone
 * @property WhereToEatCountry $country
 * @property mixed $type_id
 * @property mixed $review_count
 * @property Collection<WhereToEatFeature> $features
 * @property Collection<WhereToEatReview> $userReviews
 * @property WhereToEatType $type
 * @property string $full_location
 * @property WhereToEatVenueType $venueType
 * @property null|string $slug
 * @property number $town_id
 * @property string $full_name
 * @property string $gf_menu_link
 * @property WhereToEatOpeningTimes $openingTimes
 *
 * @method transform(array $array)
 */
class WhereToEat extends BaseModel
{
    use CreatesDailyUpdate;
    use ClearsCache;
    use Searchable;

    protected $appends = [
        'average_rating',
        'average_expense',
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

    protected $table = 'wheretoeat';

    public static function booted()
    {
        static::saving(function (self $eatery) {
            if (!$eatery->slug) {
                $eatery->slug = $eatery->generateSlug();
            }

            return $eatery;
        });
    }

    protected function hasDuplicateNameInTown(): bool
    {
        return self::query()
                ->where('town_id', $this->town_id)
                ->where('name', $this->name)
                ->where('live', 1)
                ->count() > 1;
    }

    protected function eateryPostcode(): string
    {
        $address = explode('<br />', $this->address);

        return array_pop($address);
    }

    public function generateSlug(): string
    {
        if ($this->slug) {
            return $this->slug;
        }

        return Str::of($this->name)
            ->when(
                $this->hasDuplicateNameInTown(),
                fn(Stringable $str) => $str->append(' ' . $this->eateryPostcode()),
            )
            ->slug()
            ->toString();
    }

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

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            WhereToEatFeature::class,
            'wheretoeat_assigned_features',
            'wheretoeat_id',
            'feature_id'
        )->withTimestamps();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(WhereToEatPlaceReport::class, 'wheretoeat_id');
    }

    public function getAverageRatingAttribute(): ?string
    {
        if (!$this->relationLoaded('userReviews')) {
            return null;
        }

        return (string)array_average($this->userReviews->pluck('rating')->toArray());
    }

    public function getAverageExpenseAttribute(): ?array
    {
        if (!$this->relationLoaded('userReviews')) {
            return null;
        }

        $reviewsWithHowExpense = array_filter($this->userReviews->flatten()->pluck('how_expensive')->toArray());

        if (count($reviewsWithHowExpense) === 0) {
            return null;
        }

        $average = round(array_average($reviewsWithHowExpense));

        return [
            'value' => (string)$average,
            'label' => WhereToEatReview::HOW_EXPENSIVE_LABELS[$average],
        ];
    }

    public function getHasBeenRatedAttribute(): ?bool
    {
        if (!$this->relationLoaded('userReviews')) {
            return null;
        }

        return $this->userReviews
                ->where('ip', Container::getInstance()->make(Request::class)->ip())
                ->count() > 0;
    }

    public function getIconAttribute(): ?string
    {
        if (!$this->relationLoaded('type')) {
            return null;
        }

        $file = 'place-to-eat.png';

        if ($this->type->type === 'att') {
            $file = 'attraction.png';
        }

        if ($this->type->type === 'hotel') {
            $file = 'hotel.png';
        }

        return asset('assets/images/wte-icons/' . $file);
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

    public function userReviews(): HasMany
    {
        return $this->hasMany(WhereToEatReview::class, 'wheretoeat_id', 'id');
    }

    public function userImages(): HasMany
    {
        return $this->hasMany(WhereToEatReviewImage::class, 'wheretoeat_id', 'id');
    }

    public function restaurants(): HasMany
    {
        return $this->hasMany(AttractionRestaurant::class, 'wheretoeat_id', 'id');
    }

    public function openingTimes(): HasOne
    {
        return $this->hasOne(WhereToEatOpeningTimes::class, 'wheretoeat_id', 'id');
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->name . ', ' . $this->town->town,
            'location' => $this->town->town . ', ' . $this->county->county,
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
        return (bool)$this->live;
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function getFullNameAttribute(): ?string
    {
        if (!$this->relationLoaded('town')) {
            return null;
        }

        if (Str::lower($this->town->town) === 'nationwide') {
            return "{$this->name}, Nationwide";
        }

        return implode(', ', [
            $this->name,
            $this->town->town,
            $this->county->county,
            $this->country->country,
        ]);
    }

    public function getFormattedAddressAttribute(): string
    {
        return Str::of($this->address)->explode('<br />')->join(', ');
    }

    public function getFullLocationAttribute(): ?string
    {
        if (!$this->relationLoaded('town')) {
            return null;
        }

        if (Str::lower($this->town->town) === 'nationwide') {
            return "{$this->name}, Nationwide";
        }

        return implode(', ', [
            $this->town->town,
            $this->county->county,
            $this->country->country,
        ]);
    }

    public function getTypeDescriptionAttribute(): ?string
    {
        if (!$this->relationLoaded('type')) {
            return null;
        }

        return $this->type->name;
    }

    protected function cacheKey(): string
    {
        return 'wheretoeat';
    }

    protected static function dailyUpdateType(): array
    {
        return [DailyUpdateType::WTE_COUNTY, DailyUpdateType::WTE_TOWN];
    }

    public function link(): string
    {
        return '/' . implode('/', [
                'wheretoeat',
                $this->county->slug,
                $this->town->slug,
                $this->slug,
            ]);
    }
}
