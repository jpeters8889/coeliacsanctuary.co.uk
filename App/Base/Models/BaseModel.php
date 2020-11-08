<?php

declare(strict_types=1);

namespace Coeliac\Base\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @mixin EloquentModel
 *
 * @method increment(string $field, int $amount = 1)
 * @method decrement(string $field, int $amount = 1)
 */
class BaseModel extends EloquentModel
{
    protected $guarded = [];
}
