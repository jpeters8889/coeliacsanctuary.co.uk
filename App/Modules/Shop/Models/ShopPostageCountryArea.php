<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @property mixed|string $delivery_timescale
 */
class ShopPostageCountryArea extends BaseModel
{
    public function countries()
    {
        return $this->hasMany(ShopPostageCountry::class, 'postage_area_id');
    }

    public function postagePrices()
    {
        return $this->hasMany(ShopPostagePrice::class, 'postage_country_area_id');
    }
}
