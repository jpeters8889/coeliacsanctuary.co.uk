<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @property mixed $failed
 * @property mixed $success
 * @property null|string $response
 */
class LoginAttempt extends BaseModel
{
    protected $casts = [
        'success' => 'bool',
        'failed' => 'bool',
    ];

    public static function recordFailure(string $email, string $ip, string $error): self
    {
        return self::query()->create([
           'email' => $email,
           'failed' => true,
           'response' => $error,
           'ip' => $ip,
        ]);
    }

    public static function recordSuccess(string $email, string $ip): self
    {
        return self::query()->create([
            'email' => $email,
            'success' => true,
            'ip' => $ip,
        ]);
    }
}
