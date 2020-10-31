<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;

class PlaceRequest extends BaseModel
{
    protected $casts = [
        'completed' => 'bool',
    ];
}
