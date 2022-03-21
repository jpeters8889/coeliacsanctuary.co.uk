<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string $cuisine
 * @property int $id
 */
class WhereToEatCuisine extends BaseModel
{
    protected $table = 'wheretoeat_cuisines';

    protected $visible = ['id', 'cuisine'];

    public function eateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'cuisine_id');
    }
}
