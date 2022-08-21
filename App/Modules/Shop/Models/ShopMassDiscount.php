<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @extends BaseModel<ShopMassDiscount>
 *
 * @property Collection<ShopCategory> $assignedCategories
 * @property int                      $percentage
 * @property Carbon                   $start_at
 * @property Carbon                   $end_at
 */
class ShopMassDiscount extends BaseModel
{
    protected $casts = [
        'percentage' => 'int',
        'created' => 'bool',
        'ended' => 'bool',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function assignedCategories(): BelongsToMany
    {
        return $this->belongsToMany(ShopCategory::class, 'shop_mass_discount_categories', 'mass_discount_id', 'category_id');
    }
}
