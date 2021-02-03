<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Routing\UrlGenerator;
use JPeters\Architect\Traits\HasArchitectSettings;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $email
 * @property int $user_level_id
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasArchitectSettings;

    protected $casts = [
        'user_level_id' => 'int',
    ];

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

    public function generateEmailVerificationLink(): string
    {
        return resolve(UrlGenerator::class)->temporarySignedRoute(
            'member.verify_email',
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $this->id,
                'hash' => sha1($this->email),
            ]
        );
    }
}
