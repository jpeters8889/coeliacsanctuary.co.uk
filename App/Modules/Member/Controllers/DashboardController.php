<?php

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Illuminate\Http\RedirectResponse;

class DashboardController extends BaseController
{
    public function show(): RedirectResponse
    {
        return new RedirectResponse('/member/dashboard/scrapbooks');
    }
}
