<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property ShopPostageCountryArea $area
 * @property mixed|string           $id
 * @property mixed|string           $iso_code
 */
class ShopPostageCountry extends BaseModel
{
    public const UK = 1;
    public const ROI = 2;
    public const USA = 18;
    public const AUS = 20;

    protected $visible = [
        'id',
        'country',
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(ShopPostageCountryArea::class, 'postage_area_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ShopOrder::class, 'postage_country_id');
    }
}
