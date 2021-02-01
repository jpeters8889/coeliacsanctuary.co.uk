<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;

trait CreateUser
{
    public function createUser($params = [])
    {
        /** @var User $user */
        $user = factory(User::class)->create($params);

        factory(UserAddress::class)->create(['user_id' => $user->id]);

        return $user;
    }
}
