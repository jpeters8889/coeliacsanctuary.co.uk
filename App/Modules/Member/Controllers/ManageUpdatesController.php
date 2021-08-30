<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Coeliac\Base\Controllers\BaseController;

class ManageUpdatesController extends BaseController
{
    public function __invoke(Request $request, Guard $guard): RedirectResponse
    {
        if (!$request->user()) {
            $guard->loginUsingId($request->route('id'));
        }

        return new RedirectResponse('/member/dashboard/daily-updates');
    }
}
