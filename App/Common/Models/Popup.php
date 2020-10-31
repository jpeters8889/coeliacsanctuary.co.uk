<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\DisplaysImages;

/**
 * @property int $id
 * @property int $display_every
 */
class Popup extends BaseModel
{
    use DisplaysImages;
    use Imageable;

    protected $appends = ['image'];

    protected $visible = [
        'id',
        'text',
        'link',
        'image',
    ];

    public function getImageAttribute()
    {
        return $this->first_image;
    }
}
