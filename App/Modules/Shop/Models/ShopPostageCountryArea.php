<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string $delivery_timescale
 */
class ShopPostageCountryArea extends BaseModel
{
    public function countries(): HasMany
    {
        return $this->hasMany(ShopPostageCountry::class, 'postage_area_id');
    }

    public function postagePrices(): HasMany
    {
        return $this->hasMany(ShopPostagePrice::class, 'postage_country_area_id');
    }
}
