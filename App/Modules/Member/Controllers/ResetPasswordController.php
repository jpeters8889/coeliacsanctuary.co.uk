<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Contracts\Auth\PasswordBroker;
use Coeliac\Modules\Member\Requests\ResetPasswordRequest;

class ResetPasswordController extends BaseController
{
    public function show(Page $page, $token)
    {
        return $page->doNotIndex()
            ->breadcrumbs([], 'Reset Password')
            ->setPageTitle('Reset Password')
            ->render('modules.member.reset-password', compact('token'));
    }

    public function update(ResetPasswordRequest $request, PasswordBroker $passwordBroker, Hasher $hasher)
    {
        $status = $passwordBroker->reset(
            $request->validated(),
            function (User $user, $password) use ($hasher) {
                $user->forceFill([
                    'password' => $hasher->make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                // notification
            });

        if ($status === $passwordBroker::PASSWORD_RESET) {
            return ['status' => 'reset-complete'];
        }

        return new Response(['error' => 'unknown-error'], 400);
    }
}
