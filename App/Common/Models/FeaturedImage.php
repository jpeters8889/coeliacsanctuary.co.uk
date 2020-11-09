<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\ClearsCache;
use Coeliac\Common\Traits\DisplaysImages;
use Illuminate\Database\Eloquent\Builder;

class FeaturedImage extends BaseModel
{
    use ClearsCache;
    use Imageable;
    use DisplaysImages;

    protected $appends = [
      'first_image',
    ];

    protected $visible = [
        'id',
        'title',
        'description',
        'link',
        'first_image',
        'order',
        'active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(static function (FeaturedImage $image) {
            if (!$image->order) {
                $image->order = FeaturedImage::query()->max('order');
            }
        });
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('active', 1);
    }

    protected function cacheKey(): string
    {
        return 'featured_images';
    }
}
