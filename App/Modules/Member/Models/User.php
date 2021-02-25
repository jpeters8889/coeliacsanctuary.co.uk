<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Carbon\Carbon;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Notifications\Notifiable;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use JPeters\Architect\Traits\HasArchitectSettings;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string $email
 * @property int    $user_level_id
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasArchitectSettings;

    protected $casts = [
        'id' => 'int',
        'user_level_id' => 'int',
    ];

    protected $guarded = [];

    protected $hidden = [
        'api_token',
        'password',
        'remember_token',
        'user_level_id',
    ];

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

    public function scrapbooks(): HasMany
    {
        return $this->hasMany(Scrapbook::class);
    }

    public function scrapbookItems(): HasManyThrough
    {
        return $this->hasManyThrough(ScrapbookItem::class, Scrapbook::class);
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
