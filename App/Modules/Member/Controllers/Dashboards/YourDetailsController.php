<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Requests\UpdateDetailsRequest;
use Coeliac\Modules\Member\Requests\UpdatePasswordRequest;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function update(UpdateDetailsRequest $request, Dispatcher $dispatcher): void
    {
        $currentEmail = $request->user()->email;

        $request->user()->update([
           'name' => $request->input('name'),
           'email' => $request->input('email'),
           'phone' => $request->input('phone'),
        ]);

        if ($currentEmail !== $request->input('email')) {
            $dispatcher->dispatch(new UserEmailChanged($request->user(), $currentEmail));
        }
    }

    public function password(UpdatePasswordRequest $request, Hasher $hasher, Dispatcher $dispatcher): void
    {
        $request->user()->update(['password' => $hasher->make($request->input('new'))]);

        $dispatcher->dispatch(new UserPasswordUpdated($request->user()));
    }
}
