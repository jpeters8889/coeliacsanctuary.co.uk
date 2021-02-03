<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Events\UserRegistered;
use Coeliac\Modules\Member\Requests\RegisterRequest;

class RegisterController extends BaseController
{
    public function show(Page $page): Response
    {
        return $page->breadcrumbs([], 'Register')
            ->doNotIndex()
            ->setPageTitle('Register')
            ->render('modules.member.register');
    }

    public function create(RegisterRequest $request, Hasher $hasher, Dispatcher $dispatcher, Guard $guard): RedirectResponse
    {
        $user = User::query()->firstOrCreate([
            'email' => $request->input('email'),
        ], [
            'name' => $request->input('name'),
            'password' => $hasher->make($request->input('password')),
        ]);

        $user->update(['user_level_id' => UserLevel::MEMBER]);

        $dispatcher->dispatch(new UserRegistered($user));

        $guard->login($user);
        $request->session()->regenerate();

        return new RedirectResponse('/member/dashboard');
    }
}
