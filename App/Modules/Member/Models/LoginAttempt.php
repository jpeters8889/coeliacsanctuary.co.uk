<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @extends BaseModel<LoginAttempt>
 *
 * @property mixed       $failed
 * @property mixed       $success
 * @property string|null $response
 */
class LoginAttempt extends BaseModel
{
    protected $casts = [
        'success' => 'bool',
        'failed' => 'bool',
    ];

    public static function recordFailure(string $email, string $ip, string $error): static|self
    {
        return self::query()->create([
           'email' => $email,
           'failed' => true,
           'response' => $error,
           'ip' => $ip,
        ]);
    }

    public static function recordSuccess(string $email, string $ip): static|self
    {
        return self::query()->create([
            'email' => $email,
            'success' => true,
            'ip' => $ip,
        ]);
    }
}
