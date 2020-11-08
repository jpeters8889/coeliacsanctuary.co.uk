<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property Image $image
 * @property ImageCategory $category
 */
class ImageAssociations extends BaseModel
{
    protected $with = ['image'];

    protected static function booted()
    {
        self::deleting(function(self $imageAssociation) {
            $imageAssociation->image()->delete();
        });
    }

    public function category()
    {
        return $this->belongsTo(ImageCategory::class, 'image_category_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function imageable()
    {
        return $this->morphTo('imageable');
    }

    public function scopeCategory(Builder $builder, $category)
    {
        return $builder->where('image_category_id', $category);
    }
}
