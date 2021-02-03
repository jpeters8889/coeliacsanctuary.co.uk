<?php

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

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
