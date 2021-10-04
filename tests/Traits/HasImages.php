<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Common\Models\Image;
use Tests\TestCase;

/** @mixin TestCase */
trait HasImages
{
    protected function makeImage($params = []): Image
    {
        return $this->create(Image::class, $params);
    }
}
