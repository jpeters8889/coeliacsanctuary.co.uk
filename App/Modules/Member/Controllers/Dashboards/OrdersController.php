<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class OrdersController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Purchase History')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Purchase History')
            ->render('modules.member.dashboards.orders', [
                'user' => $request->user(),
            ]);
    }

    public function list()
    {
        //
    }
}
