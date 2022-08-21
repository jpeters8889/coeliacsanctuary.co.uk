<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Notifications\ResendVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends BaseController
{
    public function show(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return new RedirectResponse('/member/dashboard');
    }

    public function create(Request $request): void
    {
        $request->user()->notify(new ResendVerifyEmail());
    }
}
