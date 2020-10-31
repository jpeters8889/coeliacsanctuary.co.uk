<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $country
 */
class WhereToEatCountry extends BaseModel
{
    protected $table = 'wheretoeat_countries';

    protected $visible = ['id', 'country'];

    public function eateries(): HasMany
    {
        return $this->hasMany(WhereToEat::class, 'country_id');
    }

    public function counties(): HasMany
    {
        return $this->hasMany(WhereToEatCounty::class, 'country_id');
    }
}
