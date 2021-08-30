<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property WhereToEat $eatery
 */
class WhereToEatRating extends BaseModel
{
    protected $table = 'wheretoeat_ratings';

    protected $casts = [
        'approved' => 'bool',
    ];

    protected $appends = ['average_rating', 'number_of_ratings'];

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id', 'id');
    }

    public function getAverageRatingAttribute(): ?string
    {
        if (!$this->relationLoaded('eatery')) {
            return null;
        }

        return number_format($this->eatery->ratings()->average('rating'), 1);
    }

    public function getNumberOfRatingsAttribute(): int|null
    {
        if (!$this->relationLoaded('eatery')) {
            return null;
        }

        return $this->eatery->ratings()->count();
    }
}
