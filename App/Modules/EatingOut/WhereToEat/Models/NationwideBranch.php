<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Scout\Searchable;

/**
 * @extends BaseModel<NationwideBranch>
 * @property int $town_id
 * @property string | null $name
 */
class NationwideBranch extends BaseModel
{
    use Searchable;

    protected $table = 'wheretoeat_nationwide_branches';

    protected $appends = ['formatted_address', 'full_location'];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

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

        return Str::of($this->name ?: $this->town->town)
            ->when(
                $this->hasDuplicateNameInTown(),
                fn (Stringable $str) => $str->append(' ' . $this->eateryPostcode()),
            )
            ->slug()
            ->toString();
    }

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id', 'id');
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

    public function getFormattedAddressAttribute(): string
    {
        return Str::of($this->address)->explode('<br />')->join(', ');
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->name . ', ' . $this->town->town,
            'location' => $this->town->town . ', ' . $this->county->county,
            'town' => $this->town->town,
            'county' => $this->county->county,
            'address' => $this->address,
            'eatery_id' => $this->eatery_id,
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

    public function getFullLocationAttribute(): ?string
    {
        if (! $this->relationLoaded('town')) {
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
}
