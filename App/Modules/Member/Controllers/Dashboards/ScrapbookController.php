<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class ScrapbookController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Scrapbooks')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Scrapbooks')
            ->render('modules.member.dashboards.scrapbook', [
                'user' => $request->user(),
            ]);
    }

    public function list(Request $request)
    {
        return $request->user()->scrapbooks()->withCount('items')->get();
    }
}
