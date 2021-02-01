<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Coeliac\Modules\Shop\Models\ShopOrder;
use JPeters\Architect\Traits\HasArchitectSettings;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $email
 * @property int $user_level_id
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasArchitectSettings;

    protected $guarded = [];

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(ShopOrder::class);
    }

    public function isMember(): bool
    {
        return $this->user_level_id !== UserLevel::SHOP;
    }

    public function isAdmin(): bool
    {
        return $this->user_level_id === UserLevel::ADMIN;
    }
}
