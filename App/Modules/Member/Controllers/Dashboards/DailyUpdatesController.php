<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Coeliac\Modules\Member\Contracts\Updatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;
use Coeliac\Modules\Member\Requests\DailyUpdateSubscribeRequest;

class DailyUpdatesController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Daily Updates')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Daily Updates')
            ->render('modules.member.dashboards.daily-updates', [
                'user' => $request->user(),
            ]);
    }

    public function list(Request $request): Collection
    {
        return $request->user()
            ->subscriptions()
            ->with(['type', 'updatable'])
            ->latest()
            ->get()
            ->map(function (UserDailyUpdateSubscription $dailyUpdate) {
                if ($dailyUpdate->daily_update_type_id === DailyUpdateType::WTE_TOWN) {
                    $dailyUpdate->load(['updatable.county']);
                }

                return $dailyUpdate;
            })
            ->transform(fn (UserDailyUpdateSubscription $dailyUpdate) => [
                'id' => $dailyUpdate->id,
                'type' => [
                    'id' => $dailyUpdate->type->id,
                    'name' => $dailyUpdate->type->name,
                    'description' => $dailyUpdate->type->description,
                ],
                'updatable' => [
                    'id' => $dailyUpdate->updatable->id,
                    'name' => $dailyUpdate->updatable->updatableName(),
                    'link' => $dailyUpdate->updatable->updatableLink(),
                ],
                'created_at' => $dailyUpdate->created_at,
            ])
            ->values();
    }

    public function create(DailyUpdateSubscribeRequest $request): void
    {
        abort_if(!$request->updatable() instanceof Updatable, 400);

        $request->dailyUpdate()->subscribe($request->user(), $request->updatable());
    }

    public function delete(UserDailyUpdateSubscription $dailyUpdate, Gate $gate): void
    {
        $gate->authorize('manage-daily-updates', $dailyUpdate);

        $dailyUpdate->delete();
    }
}
