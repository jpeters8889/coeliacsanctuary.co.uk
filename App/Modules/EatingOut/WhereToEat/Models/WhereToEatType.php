<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $type
 */
class WhereToEatType extends BaseModel
{
    protected $table = 'wheretoeat_types';

    protected $visible = ['id', 'type', 'name'];

    public function eateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'type_id');
    }
}
