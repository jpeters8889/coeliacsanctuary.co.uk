<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Coeliac\Base\Controllers\BaseController;

class LogoutController extends BaseController
{
    public function __invoke(Request $request, Guard $guard)
    {
        $guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
