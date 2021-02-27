<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Coeliac\Modules\Member\Models\UserSubscription;
use Coeliac\Modules\Member\Requests\CreateSubscriptionRequest;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class SubscriptionsController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Subscriptions')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Subscriptions')
            ->render('modules.member.dashboards.subscriptions', [
                'user' => $request->user(),
            ]);
    }

    public function list()
    {
        //
    }

    public function create(CreateSubscriptionRequest $request)
    {
        $request->subscription()->subscribe($request->user(), $request->subscribable());
    }

    public function delete(UserSubscription $subscription, Gate $gate)
    {
        $gate->authorize('manage-subscription', $subscription);

        $subscription->delete();
    }
}
