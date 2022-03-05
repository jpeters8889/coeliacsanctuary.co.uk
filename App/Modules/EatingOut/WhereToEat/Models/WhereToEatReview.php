<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property WhereToEat $eatery
 * @property int $id
 * @property mixed $rating
 */
class WhereToEatReview extends BaseModel
{
    public const PRICE_RANGE_LABELS = [
        1 => 'Low Price',
        2 => 'Great Value',
        3 => 'Average',
        4 => 'A special treat',
        5 => 'Expensive',
    ];

    protected $table = 'wheretoeat_reviews';

    protected $casts = [
        'approved' => 'bool',
    ];

    protected $appends = ['average_rating', 'number_of_ratings', 'human_date', 'price'];

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id', 'id');
    }

    public function getAverageRatingAttribute(): ?string
    {
        if (!$this->relationLoaded('eatery')) {
            return null;
        }

        return number_format($this->eatery->userReviews()->average('rating'), 1);
    }

    public function getNumberOfRatingsAttribute(): int|null
    {
        if (!$this->relationLoaded('eatery')) {
            return null;
        }

        return $this->eatery->userReviews()->count();
    }

    public function getHumanDateAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getPriceAttribute(): ?array
    {
        if (!$this->price_range) {
            return null;
        }

        return [
            'value' => $this->price_range,
            'label' => self::PRICE_RANGE_LABELS[$this->price_range],
        ];
    }
}
