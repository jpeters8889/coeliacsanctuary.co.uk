<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Carbon\Carbon;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Notifications\Notifiable;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use JPeters\Architect\Traits\HasArchitectSettings;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Coeliac\Modules\Member\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string $email
 * @property int    $user_level_id
 * @property Carbon last_logged_in_at
 * @property Carbon last_visited_at
 * @property int id
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasArchitectSettings;

    protected $casts = [
        'id' => 'int',
        'user_level_id' => 'int',
    ];

    protected $dates = [
        'last_logged_in_at',
        'last_visited_at',
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

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserDailyUpdateSubscription::class);
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

    public function generateManageDailyUpdatesLink(): string
    {
        return resolve(UrlGenerator::class)->temporarySignedRoute(
            'member.manage_updates',
            Carbon::now()->addHours(24),
            [
                'id' => $this->id,
                'hash' => sha1($this->email),
            ]
        );
    }

    public function sendPasswordResetNotification($token)
    {
        $url = implode('/', [
            Container::getInstance()->make(Repository::class)->get('app.url'),
            'member',
            'reset-password',
            $token,
        ]);

        $this->notify(new ResetPassword($url));
    }

    public function passwordChanges(): HasMany
    {
        return $this->hasMany(UserPasswordChange::class);
    }
}
