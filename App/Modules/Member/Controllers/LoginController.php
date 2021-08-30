<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Auth\Guard;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\LoginAttempt;
use Coeliac\Modules\Member\Requests\LoginRequest;

class LoginController extends BaseController
{
    public function show(Page $page): Response
    {
        return $page->breadcrumbs([], 'Member Login')
            ->doNotIndex()
            ->setPageTitle('Member Login')
            ->render('modules.member.login');
    }

    public function create(LoginRequest $request, Guard $guard): Response
    {
        if (!$request->userExists() || !$request->userIsActive()) {
            LoginAttempt::recordFailure(
                $request->input('email'),
                (string) $request->ip(),
                !$request->userExists() ? "User doesn't exist" : 'User is shop user only'
            );

            return new Response([], 422);
        }

        if ($guard->attempt($request->validated(), true)) {
            $request->session()->regenerate();
            $request->user()->update(['last_logged_in_at' => Carbon::now()]);
            LoginAttempt::recordSuccess($request->input('email'), (string) $request->ip());

            return new Response([]);
        }

        LoginAttempt::recordFailure(
            $request->input('email', ''),
            (string) $request->ip(),
            'Unknown error',
        );

        return new Response([], 422);
    }
}
