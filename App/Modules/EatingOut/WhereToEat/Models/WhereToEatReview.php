<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\ClearsCache;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property WhereToEat $eatery
 * @property int $id
 * @property mixed $rating
 * @property int $wheretoeat_id
 * @property bool $admin_review
 * @property int $how_expensive
 */
class WhereToEatReview extends BaseModel
{
    use ClearsCache;

    public const HOW_EXPENSIVE_LABELS = [
        1 => 'Cheap Eats',
        2 => 'Great Value',
        3 => 'Average / Mid Range',
        4 => 'A special treat',
        5 => 'Expensive',
    ];

    protected $table = 'wheretoeat_reviews';

    protected $casts = [
        'admin_review' => 'bool',
        'approved' => 'bool',
    ];

    protected $appends = ['average_rating', 'number_of_ratings', 'human_date', 'price'];

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id', 'id');
    }

    public function getAverageRatingAttribute(): ?string
    {
        if (! $this->relationLoaded('eatery')) {
            return null;
        }

        return number_format($this->eatery->userReviews()->average('rating'), 1);
    }

    public function getNumberOfRatingsAttribute(): int|null
    {
        if (! $this->relationLoaded('eatery')) {
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
        if (! $this->how_expensive) {
            return null;
        }

        return [
            'value' => $this->how_expensive,
            'label' => self::HOW_EXPENSIVE_LABELS[$this->how_expensive],
        ];
    }

    public function images(): HasMany
    {
        return $this->hasMany(WhereToEatReviewImage::class, 'wheretoeat_review_id', 'id');
    }

    protected function cacheKey(): string
    {
        return 'wheretoeat_reviews';
    }
}
