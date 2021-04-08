<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

class LoginAttempt extends BaseModel
{
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
