<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Member\Events\UserPasswordReset;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Requests\ResetPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ResetPasswordController extends BaseController
{
    public function show(Page $page, string $token): Response
    {
        return $page->doNotIndex()
            ->breadcrumbs([], 'Reset Password')
            ->setPageTitle('Reset Password')
            ->render('modules.member.reset-password', compact('token'));
    }

    public function update(ResetPasswordRequest $request, PasswordBroker $passwordBroker, Hasher $hasher, Dispatcher $dispatcher): array|Response
    {
        $status = $passwordBroker->reset(
            $request->validated(),
            function (User $user, $password) use ($hasher, $dispatcher) {
                $user->forceFill([
                    'password' => $hasher->make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                $dispatcher->dispatch(new UserPasswordReset($user));
            }
        );

        if ($status === $passwordBroker::PASSWORD_RESET) {
            return ['status' => 'reset-complete'];
        }

        return new Response(['error' => 'unknown-error'], 400);
    }
}
