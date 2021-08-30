<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Rules\MemberEmailIsntActive;

class RegisterRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', new MemberEmailIsntActive()],
            'password' => ['required', 'confirmed', 'min:8'],
            'terms' => ['required', 'accepted'],
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

    public function userIsVerified(): bool
    {
        return User::query()
            ->where('email', $this->input('email'))
            ->whereNotNull('email_verified_at')
            ->exists();
    }
}
