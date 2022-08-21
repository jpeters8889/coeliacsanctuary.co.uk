<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ManageUpdatesController extends BaseController
{
    public function __invoke(Request $request, Guard $guard): RedirectResponse
    {
        if (! $request->user()) {
            $guard->loginUsingId($request->route('id'));
        }

        return new RedirectResponse('/member/dashboard/daily-updates');
    }
}
