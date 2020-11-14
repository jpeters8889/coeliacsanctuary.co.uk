<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Coeliac\Common\Models\Image;
use Coeliac\Base\Models\BaseModel;

/**
 * @property string $main_image
 * @property string $social_image
 * @property string $square_image
 * @property string $first_image
 * @mixin BaseModel
 */
trait DisplaysImages
{
    public function getFirstImageAttribute()
    {
        return $this->images->first()->image->image_url ?? null;
    }

    public function getMainImageAttribute()
    {
        return $this->images
                ->whereIn('image_category_id', [Image::IMAGE_CATEGORY_HEADER, Image::IMAGE_CATEGORY_SQUARE])
                ->sortBy('image_category_id')
                ->first()
                ->image
                ->image_url ?? null;
    }

    public function getSocialImageAttribute()
    {
        return $this->images
                ->firstWhere('image_category_id', Image::IMAGE_CATEGORY_SOCIAL)
                ->image
                ->image_url ?? null;
    }

    public function getSquareImageAttribute()
    {
        return $this->images
                ->firstWhere('image_category_id', Image::IMAGE_CATEGORY_SQUARE)
                ->image
                ->image_url ?? null;
    }
}
