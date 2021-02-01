<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Auth\SessionGuard;
use Coeliac\Base\Controllers\BaseController;
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

    public function create(LoginRequest $request, Guard $guard)
    {
        if (!$request->userExists() || !$request->userIsActive()) {
            return new Response([], 422);
        }

        if (!$request->userIsVerified()) {
            return new Response(['message' => 'email not verified'], 422);
        }

        if ($guard->attempt($request->validated(), true)) {
            $request->session()->regenerate();

            return new Response([]);
        }

        return new Response([], 422);
    }
}
