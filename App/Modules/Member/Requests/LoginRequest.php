<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;

class LoginRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
          'email' => ['required', 'email'],
          'password' => ['required'],
        ];
    }

    public function userExists(): bool
    {
        return User::query()->where('email', $this->input('email'))->exists();
    }

    public function userIsActive(): bool
    {
        return User::query()
            ->where('email', $this->input('email'))
            ->where('user_level_id', '!=', UserLevel::SHOP)
            ->exists();
    }
}
