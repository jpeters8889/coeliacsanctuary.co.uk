<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Container\Container;
use Illuminate\Filesystem\FilesystemManager;

/**
 * @property string $directory
 * @property string $file_name
 * @property string $image_url
 * @property string $raw_url
 */
class Image extends BaseModel
{
    public const IMAGE_CATEGORY_GENERAL = 1;
    public const IMAGE_CATEGORY_HEADER = 2;
    public const IMAGE_CATEGORY_SOCIAL = 3;
    public const IMAGE_CATEGORY_SQUARE = 4;
    public const IMAGE_CATEGORY_HERO = 5;
    public const IMAGE_CATEGORY_POPUP = 6;
    public const IMAGE_CATEGORY_SHOP_CATEGORY = 7;
    public const IMAGE_CATEGORY_SHOP_PRODUCT = 8;

    protected $appends = ['image_url'];

    public static function booted()
    {
        static::deleted(static function (Image $image) {
            Container::getInstance()->make(FilesystemManager::class)
                ->disk('images')
                ->delete($image->directory . '/' . $image->file_name);
        });
    }

    public function associations()
    {
        return $this->hasMany(ImageAssociations::class);
    }

    public function getRawUrlAttribute()
    {
        return Container::getInstance()->make(FilesystemManager::class)->disk('images')->url($this->directory . '/' . $this->file_name);
    }

    public function getImageUrlAttribute()
    {
        if (config('app.env') === 'testing') {
            // @todo this sucks
            return Container::getInstance()->make(FilesystemManager::class)->disk('images')->url($this->directory . '/' . $this->file_name);
        }

        return implode('/', [
            config('coeliac.images_url'),
            $this->directory,
            $this->file_name,
        ]);
    }
}
