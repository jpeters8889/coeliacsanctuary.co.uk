<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed|string $id
 * @property User         $user
 * @property mixed|string $name
 * @property mixed|string $line_1
 * @property mixed|string $line_2
 * @property mixed|string $line_3
 * @property mixed|string $town
 * @property mixed|string $postcode
 */
class UserAddress extends BaseModel
{
    use SoftDeletes;

    protected $casts = ['user_id' => 'int'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(ShopOrder::class, 'user_address_id');
    }

    public function getFormattedAddressAttribute()
    {
        return implode('<br/>', array_filter([
            $this->name,
            $this->line_1,
            $this->line_2,
            $this->line_3,
            $this->town,
            $this->postcode,
        ]));
    }
}
