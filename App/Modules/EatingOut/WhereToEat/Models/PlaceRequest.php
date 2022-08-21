<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;

/** @extends BaseModel<PlaceRequest> */
class PlaceRequest extends BaseModel
{
    protected $casts = [
        'completed' => 'bool',
    ];
}
