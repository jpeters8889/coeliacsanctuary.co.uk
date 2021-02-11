<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Pagination\LengthAwarePaginator;
use Coeliac\Modules\Member\Requests\ViewOrderRequest;
use Coeliac\Modules\Member\Services\ShopOrderService;

class OrdersController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Purchase History')
            ->breadcrumbs([
                [
                    'title' => 'Your Dashboard',
                    'link' => '/member/dashboard',
                ],
            ], 'Purchase History')
            ->render('modules.member.dashboards.orders', [
                'user' => $request->user(),
            ]);
    }

    public function list(ShopOrderService $orderService): LengthAwarePaginator
    {
        return $orderService->list()->paginate(10);
    }

    public function get(ViewOrderRequest $request, ShopOrderService $orderService): array
    {
        return $orderService->info($request->order());
    }
}
