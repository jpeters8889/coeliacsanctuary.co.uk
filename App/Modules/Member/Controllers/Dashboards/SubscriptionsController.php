<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\SubscriptionType;
use Coeliac\Modules\Member\Models\UserSubscription;
use Coeliac\Modules\Member\Requests\SubscriptionCreateRequest;

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

    public function list(Request $request)
    {
        return $request->user()
            ->subscriptions()
            ->with(['type', 'subscribable'])
            ->get()
            ->map(function (UserSubscription $subscription) {
                if ($subscription->user_subscription_type_id === SubscriptionType::WTE_TOWN) {
                    $subscription->load(['subscribable.county']);
                }

                return $subscription;
            })
            ->transform(fn (UserSubscription $subscription) => [
                'id' => $subscription->id,
                'type' => [
                    'id' => $subscription->type->id,
                    'name' => $subscription->type->name,
                ],
                'subscribable' => [
                    'id' => $subscription->subscribable->id,
                    'name' => $subscription->subscribable->subscribableName(),
                    'link' => $subscription->subscribable->subscribableLink(),
                ],
                'created_at' => $subscription->created_at,
            ]);
    }

    public function create(SubscriptionCreateRequest $request)
    {
        $request->subscription()->subscribe($request->user(), $request->subscribable());
    }

    public function delete(UserSubscription $subscription, Gate $gate)
    {
        $gate->authorize('manage-subscription', $subscription);

        $subscription->delete();
    }
}
