<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Str;

/**
 * @property WhereToEat $eatery
 * @property int $id
 * @property mixed $rating
 */
class WhereToEatReviewImage extends BaseModel
{
    protected $table = 'wheretoeat_review_images';

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function booted()
    {
        self::creating(function (self $model) {
            $model->id ??= Str::uuid()->toString();

            return $model;
        });
    }

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id', 'id');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(WhereToEatReview::class, 'wheretoeat_review_id', 'id');
    }

    public function getThumbAttribute($thumb): string
    {
        return $this->imageUrl($thumb);
    }

    public function getPathAttribute($path): string
    {
        return $this->imageUrl($path);
    }

    protected function imageUrl($file)
    {
        return app(FilesystemManager::class)->disk('review-images')->url($file);
    }
}
