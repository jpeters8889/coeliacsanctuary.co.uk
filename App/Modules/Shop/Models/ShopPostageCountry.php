<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ShopPostageCountryArea $area
 * @property mixed|string           $id
 * @property mixed|string           $iso_code
 */
class ShopPostageCountry extends BaseModel
{
    public const UK = 1;

    protected $visible = [
        'id',
        'country',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(ShopPostageCountryArea::class, 'postage_area_id');
    }

    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'postage_country_id');
    }
}
