<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Coeliac\Modules\Member\Notifications\ResendVerifyEmail;

class VerifyEmailController extends BaseController
{
    public function show(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return new RedirectResponse('/member/dashboard');
    }

    public function create(Request $request)
    {
        $request->user()->notify(new ResendVerifyEmail());
    }
}
