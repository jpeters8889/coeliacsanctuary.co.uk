<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Rules;

use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Member\Models\UserLevel;

class MemberEmailIsntActive implements Rule
{
    public function passes($attribute, $value)
    {
        $userCheck = User::query()->where('email', $value)->first();

        if (!$userCheck) {
            return true;
        }

        return $userCheck->user_level_id === UserLevel::SHOP;
    }

    public function message()
    {
        return 'Your email is already associated with an account!';
    }
}
