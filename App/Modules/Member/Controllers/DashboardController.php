<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Http\RedirectResponse;
use Coeliac\Base\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function show(): RedirectResponse
    {
        return new RedirectResponse('/member/dashboard/scrapbooks');
    }
}
