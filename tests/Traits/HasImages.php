<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Common\Models\Image;

trait HasImages
{
    protected function makeImage($params = []): Image
    {
        return factory(Image::class)->create($params);
    }
}
