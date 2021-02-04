<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class YourDetailsController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Your Details')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Your Details')
            ->render('modules.member.dashboards.details', [
                'user' => $request->user(),
            ]);
    }
}
