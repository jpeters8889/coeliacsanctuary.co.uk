<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Events\UserEmailChanged;
use Coeliac\Modules\Member\Events\UserPasswordUpdated;
use Coeliac\Modules\Member\Requests\UpdateDetailsRequest;
use Coeliac\Modules\Member\Requests\UpdatePasswordRequest;

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

    public function update(UpdateDetailsRequest $request, Dispatcher $dispatcher)
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

    public function password(UpdatePasswordRequest $request, Hasher $hasher, Dispatcher $dispatcher)
    {
        $request->user()->update(['password' => $hasher->make($request->input('new'))]);

        $dispatcher->dispatch(new UserPasswordUpdated($request->user()));
    }
}