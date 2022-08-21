<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @extends BaseModel<WhereToEatVenueType>
 *
 * @property mixed|string $venue_type
 * @property int $id
 */
class WhereToEatVenueType extends BaseModel
{
    protected $table = 'wheretoeat_venue_types';

    protected $visible = ['id', 'venue_type'];

    public function eateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'venue_type_id');
    }
}
