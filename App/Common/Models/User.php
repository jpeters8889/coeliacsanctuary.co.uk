<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Illuminate\Notifications\Notifiable;
use Coeliac\Modules\Shop\Models\ShopOrder;
use JPeters\Architect\Traits\HasArchitectSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $email
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasArchitectSettings;

    protected $guarded = [];

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function orders()
    {
        return $this->hasMany(ShopOrder::class);
    }
}
