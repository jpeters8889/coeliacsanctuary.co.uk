<?php

declare(strict_types=1);

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
